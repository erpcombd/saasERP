<?php

class TorCsvImporter
{ 

    protected $insertCount = 0;
    protected $mappings = [];
    protected $insertedIds = [];
    protected $file;
    protected $validCols = [];
    protected $tableName;
    protected $lastInsertId = 0;

    public function __construct($csvFile, $tableName)
    {
        $this->file = $csvFile;
        $this->tableName = $tableName;
    }

    public function getInsertedIds()
    {
        return $this->insertedIds;
    }

    public function setMappings(array $mappings)
    {
        $this->mappings = $mappings;
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


    protected function loadTableColumns($tableName)
    {
        $res = db_query("SHOW COLUMNS FROM $tableName");
        while ($col = mysqli_fetch_assoc($res)) {
            $this->validCols[] = $col['Field'];
        }
    }


    private function getId($table, $idCol, $nameCol, $value)
    {
        return find_a_field($table, $idCol, "$nameCol='" . addslashes($value) . "'");
    }


    protected function applyMappings($row, $header, &$finalCols, &$finalVals)
    {
        foreach ($this->mappings as $map) {
            if (!in_array($map['column'], $this->validCols)) continue;

            $sourceIndex = array_search($map['source_column'], $header);
            if ($sourceIndex === false) continue;

            $sourceValue = $row[$sourceIndex];
            $mappedId = $this->getId($map['table'], $map['id_field'], $map['name_field'], $sourceValue);

            $finalCols[] = $map['column'];
            $finalVals[] = $mappedId;
        }
    }


    protected function insertRow($table, $columns, $values)
    {
        $cols = implode(',', $columns);
        $vals = "'" . implode("','", array_map('addslashes', $values)) . "'";
        $sql = "INSERT INTO $table ($cols) VALUES ($vals)";
        db_query($sql);
        $this->insertCount++;
        $this->lastInsertId = db_insert_id();
        $this->insertedIds[] = $this->lastInsertId;
    }
    
    public function createSubLedger($code, $name, $tr_from, $tr_id, $ledger_id, $type)
    {
        $sql = 'INSERT INTO general_sub_ledger SET 
        sub_ledger_id="' . $code . '",
        sub_ledger_name="' . addslashes($name) . '",
        tr_from="' . $tr_from . '",
        tr_id="' . $tr_id . '",
        ledger_id="' . $ledger_id . '",
        type="' . $type . '",
        entry_at="' . date('Y-m-d H:i:s') . '",
        entry_by="' . ($_SESSION['user']['id'] ?? 0) . '",
        group_for="' . ($_SESSION['user']['group'] ?? '') . '"';

        db_query($sql);
    }
}
