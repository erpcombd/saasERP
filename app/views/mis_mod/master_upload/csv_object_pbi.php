<?php

require_once 'csv_object.php';

class TorCsvImporterpbi extends TorCsvImporter
{


    public function getLastInsertId()
    {
        $id = $this->lastInsertId;
        $sql = "UPDATE `" . addslashes($this->tableName) . "` SET PBI_CODE = '" . addslashes($id) . "' WHERE PBI_ID = '" . addslashes($id) . "'";

        db_query($sql);
    }

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


            $this->applyMappings($row, $header, $finalCols, $finalVals);

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


    protected function insertRow($table, $columns, $values)
    {
        parent::insertRow($table, $columns, $values);

        $pbiCodeIndex = array_search('PBI_CODE', $columns);
        $pbiCodeValue = $pbiCodeIndex !== false ? $values[$pbiCodeIndex] : null;

        if (in_array('PBI_CODE', $this->validCols) && empty($pbiCodeValue)) {
            $this->getLastInsertId();
        }
    }
}
