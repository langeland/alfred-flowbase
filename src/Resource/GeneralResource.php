<?php

namespace FlowBase\Resource;

class GeneralResource extends AbstractResource
{

    protected $searchIndexFields = [];
    protected static $storageFields = [];

    public static function getStorageFields(): array
    {
        return self::$storageFields;
    }
    
}