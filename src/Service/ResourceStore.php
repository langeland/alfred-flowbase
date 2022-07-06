<?php

namespace FlowBase\Service;

use FlowBase\Resource\ResourceInterface;
use FlowBase\Utility\Debugger;

class ResourceStore extends \SQLite3
{

    /**
     * @var string
     */
    protected $tableName;

    /**
     * @var array
     */
    protected $supportedResourceTypes = [];

    /**
     * ResourceStore constructor.
     * @param array $supportedResourceTypes
     * @param string $databaseName
     * @param string $tableName
     */
    function __construct(array $supportedResourceTypes, $databaseName = 'ResourceStore', $tableName = 'Resource')
    {
        $this->tableName = $tableName;
        $this->supportedResourceTypes = $supportedResourceTypes;
        $databaseFile = $_SERVER['alfred_workflow_data'] . '/' . $databaseName . '.db';
        $this->open($databaseFile);

        $this->createTable();
    }

    /**
     * @return ResourceInterface
     */
    public function findOneBy($field, $value, $resourceType = null): \FlowBase\Resource\ResourceInterface
    {
        $resources = $this->findBy($field, $value, $resourceType);
        return $resources[0];
    }

    /**
     * @return \FlowBase\Resource\ResourceInterface[]
     */
    public function findBy($field, $value, $resourceType = null): array
    {
        if (is_numeric($value) === false) {
            $value = '"' . $value . '"';
        }
        $where = $field . '=' . $value;

        if($resourceType !== null){
            $where = ' AND resourceClass' . '=' . $resourceType;
        }

        return $this->find($where);
    }

    /**
     * @param $where
     * @return \FlowBase\Resource\ResourceInterface[]
     */
    public function find($where): array
    {
        $results = $this->query(sprintf(
            'select * from %s where %s',
            $this->tableName,
            $where
        ));

        $collection = $this->namalizeResult($results);
        return $collection;
    }

    /**
     * @param $term
     * @return array
     */
    public function search($term): array
    {
        $termParts = explode(' ', $term);
        array_walk(
            $termParts,
            function (&$queryPart, $key) use ($termParts) {
                $queryPart = 'search LIKE "%' . $queryPart . '%"';
            }
        );
        $where = implode(' AND ', $termParts);

        return $this->find($where);
    }

    /**
     *
     */
    public function destroy()
    {
        $this->exec('drop table if exists ' . $this->tableName);
    }

    /**
     *
     */
    public function createTable()
    {
        $resourceFields = [];
        /** @var ResourceInterface $supportedResourceType */
        foreach ($this->supportedResourceTypes as $supportedResourceType) {
            $resourceFields = array_merge(
                $resourceFields,
                $supportedResourceType::getStorageFields()
            );
        }

        $resourceFields = array_merge(
            [
                'identifier' => 'TEXT',
                'search' => 'BLOB',
                'resourceClass' => 'TEXT',
                'resourceData' => 'BLOB'
            ],
            $resourceFields
        );

        $fieldDefinitions = [];
        foreach ($resourceFields as $resourceFieldName => $resourceFieldType) {
            $fieldDefinitions[] = $resourceFieldName . ' ' . $resourceFieldType;
        }

        $query = sprintf(
            'create table if not exists %s ( %s )',
            $this->tableName,
            implode(', ', $fieldDefinitions)
        );

        $execResult = $this->exec($query);
        if ($execResult == false) {
            Debugger::log('Error while inserting resource: ' . $resource->getIdentifier(), ['query' => $query]);
        }

    }

    /**
     * @param ResourceInterface $resource
     */
    public function insertResource(\FlowBase\Resource\ResourceInterface $resource): void
    {
        $dataFields = [
            'identifier' => $resource->getIdentifier(),
            'search' => ' ' . $resource->getSearchIndex() . ' ',
            'resourceClass' => get_class($resource),
            'resourceData' => base64_encode(json_encode($resource))
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
            $this->tableName,
            implode(', ', array_keys($dataFields)),
            implode(', ', array_values($dataFields))
        );

        $execResult = $this->exec($query);
        if ($execResult == false) {
            Debugger::log('Error while inserting resource: ' . $resource->getIdentifier(), ['query' => $query]);
        }
    }

    /**
     * @param \SQLite3Result $result
     * @return array
     */
    private function namalizeResult(\SQLite3Result $result): array
    {
        $collection = array();
        while ($resultRow = $result->fetchArray(SQLITE3_ASSOC)) {
            $resourceClass = $resultRow['resourceClass'];
            array_push(
                $collection,
                $resourceClass::constructFromBase64($resultRow['resourceData'])
            );
        }

        return $collection;
    }

    public function __destruct()
    {
        $this->close();
    }
}