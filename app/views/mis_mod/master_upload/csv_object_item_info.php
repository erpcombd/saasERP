<?php

require_once 'csv_object.php';
class TorCsvImporterItemInfo extends TorCsvImporter
{

    public function import()
    {
        $handle = fopen($this->file, "r");
        $header = fgetcsv($handle);
        $this->loadTableColumns($this->tableName);

        while (($row = fgetcsv($handle)) !== false) {
            $finalCols = [];
            $finalVals = [];

            foreach ($header as $index => $colName) {
                if (in_array($colName, $this->validCols)) {
                    $finalCols[] = $colName;
                    $finalVals[] = $row[$index];
                }
            }

            // Apply any mappings
            $this->applyMappings($row, $header, $finalCols, $finalVals);

            $subGroupId = null;
            foreach ($finalCols as $i => $col) {
                if ($col === 'sub_group_id') {
                    $subGroupId = $finalVals[$i];
                    break;
                }
            }

            $itemNameIndex = array_search('item_name', $header);
            $itemName = $itemNameIndex !== false ? $row[$itemNameIndex] : null;


            if (!$subGroupId || !$itemName) {
                echo "<span style='color:red;'>Skipping row: missing sub_group_id or item_name</span><br>";
                continue;
            }


            $min = $subGroupId + 1;
            $max = $subGroupId + 10000;
            $itemId = next_value('item_id', $this->tableName, '1', $min, $min, $max);


            $customCode = find_a_field('item_info', 'max(sub_ledger_id)', '1');

            $subLedgerId = $customCode > 0 ? $customCode + 1 : 30000001;

            $accountCode = find_a_field('item_sub_group', 'item_ledger', 'sub_group_id="' . addslashes($subGroupId) . '"');


            $finalCols[] = 'item_id';
            $finalVals[] = $itemId;

            $finalCols[] = 'sub_ledger_id';
            $finalVals[] = $subLedgerId;


            $ledgerExists = find_a_field('general_sub_ledger', 'sub_ledger_id', 'sub_ledger_name="' . addslashes($itemName) . '"');

            if (!$ledgerExists) {
                $this->createSubLedger($subLedgerId, $itemName, 'item', $itemId, $accountCode, $subGroupId);
            }

            if (in_array('entry_by', $this->validCols)) {
                $finalCols[] = 'entry_by';
                $finalVals[] = $_SESSION['user']['id'] ?? 0;
            }

            if (in_array('entry_at', $this->validCols)) {
                $finalCols[] = 'entry_at';
                $finalVals[] = date("Y-m-d H:i:s");
            }
            $this->insertRow($this->tableName, $finalCols, $finalVals);
        }



        fclose($handle);
        return $this->insertCount;
    }
}
