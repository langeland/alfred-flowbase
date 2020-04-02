<?php

namespace FlowBase\Service;

use FlowBase\Utility\Debugger;

class ResourceStore extends \SQLite3
{
    protected $resourceType;

    function __construct(string $resourceType, $databaseName = 'ResourceStore')
    {
        $this->resourceType = $resourceType;
        $databaseFile = $_SERVER['alfred_workflow_data'] . '/' . $databaseName . '.db';
        $this->open($databaseFile);

        $this->createTable(
            $this->resourceType
        );
    }

    public function findOne(): \FlowBase\Resource\ResourceInterface
    {
    }

    public function find(): \FlowBase\Resource\ResourceInterface
    {
    }

    public function search($term)
    {
        $termParts = explode(' ', $term);
        array_walk(
            $termParts,
            function (&$queryPart, $key) use ($termParts) {
                $queryPart = 'search LIKE "%' . $queryPart . '%"';
            }
        );
        $where = implode(' AND ', $termParts);

        $query = sprintf(
            'select * from %s where %s',
            $this->resolveTableName($this->resourceType),
            $where
        );

        $results = $this->query($query);

        $collection = array();
        while ($result = $results->fetchArray(SQLITE3_ASSOC)) {
            $resource = $this->resourceType::constructFromBase64($result['object']);
            array_push($collection, $resource);
        }

        return $collection;
    }

    public function insertResource(\FlowBase\Resource\ResourceInterface $resource)
    {
        $dataFields = [
            'identifier' => $resource->getIdentifier(),
            'search' => ' ' . $resource->getSearchIndex() . ' ',
            'object' => base64_encode(json_encode($resource))
        ];

        $storageFields = $resource::getStorageFields();
        foreach (array_keys($storageFields) as $storageField) {
            $dataFields[$storageField] = $resource->get($storageField);
        }

        array_walk($dataFields, function (&$value, $key) {
            if (is_numeric($value) === false) {
                $value = '"' . $value . '"';
            }
        });

        $query = sprintf(
            'INSERT INTO %s (%s) VALUES(%s);',
            $this->resolveTableName($resource),
            implode(', ', array_keys($dataFields)),
            implode(', ', array_values($dataFields))
        );

        $this->exec($query);
    }

    public function delete(\FlowBase\Resource\ResourceInterface $resource)
    {
    }

    public function deleteByIdentifier(string $resourceIdentifier)
    {
    }

    public function destroy()
    {
        $this->exec('drop table if exists ' . $this->resolveTableName($this->resourceType));
    }

    public function createTable()
    {
        $tableFields = array_merge(
            [
                'identifier' => 'TEXT',
                'search' => 'BLOB',
                'object' => 'BLOB'
            ],
            $this->resourceType::getStorageFields()
        );


        $fieldDef = "";
        $numFields = count($tableFields);
        $inc = 1;

        foreach ($tableFields as $field => $type) {
            $fieldDef .= $field . " " . strtoupper($type);
            if ($inc != $numFields) {
                $fieldDef .= ', ';
            }
            $inc++;
        }

        $query = sprintf(
            'create table if not exists %s ( %s )',
            $this->resolveTableName($this->resourceType),
            $fieldDef
        );

        Debugger::log('createTable: ' . $query);
        $this->exec($query);
    }

    private function resolveTableName($resource)
    {
        if (is_object($resource)) {
            return substr(strrchr(get_class($resource), '\\'), 1);
        }
        return substr(strrchr($resource, '\\'), 1);
    }

    public function __destruct()
    {
        $this->close();
    }
}