<?php

namespace FlowBase\Service;

class LocalDatabase extends \SQLite3
{

    function __construct($name = "database.db")
    {
        $this->open($name);
    }

    public function single($table, $where = '1', $select = '*')
    {
        $result = $this->querySingle('select ' . $select . ' from ' . $table . ' where ' . $where, true);
        return $result;
//        return json_decode(json_encode($result, JSON_FORCE_OBJECT));
    }

    public function get($table, $where = '1', $select = '*')
    {
        $results = $this->query('select ' . $select . ' from ' . $table . ' where ' . $where);
        $return = array();
        while ($result = $results->fetchArray(SQLITE3_ASSOC)):
            array_push($return, $result);
        endwhile;
        return $return;
//        return json_decode(json_encode($return));
    }

    public function insert($table, $values)
    {
        $fieldOrder = "";
        $valueOrder = "";
        $numFields = count($values);
        $inc = 1;

        foreach ($values as $field => $value):
            $fieldOrder .= $field;
            if ($inc != $numFields):
                $fieldOrder .= ', ';
            endif;
            $valueOrder .= '"' . $value . '"';
            if ($inc != $numFields):
                $valueOrder .= ', ';
            endif;
            $inc++;
        endforeach;
        $this->exec('insert into ' . $table . ' values ( ' . $valueOrder . ' )');
    }

    public function delete($table, $where)
    {
        $this->exec('delete from ' . $table . ' where ' . $where);
    }

    public function update($table, $where, $values)
    {
        $setValues = "";
    }

    public function createTable($table, $fields)
    {
        $fieldDef = "";
        $numFields = count($fields);
        $inc = 1;

        foreach ($fields as $field => $type):
            $fieldDef .= $field . " " . strtoupper($type);
            if ($inc != $numFields):
                $fieldDef .= ', ';
            endif;
            $inc++;
        endforeach;

        $this->exec('create table if not exists ' . $table . '( ' . $fieldDef . ' )');
    }

    public function dropTable($table)
    {
        $this->exec('drop table if exists ' . $table);
    }

    function __destruct()
    {
        $this->close();
    }

}