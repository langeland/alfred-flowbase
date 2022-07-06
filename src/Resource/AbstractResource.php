<?php

namespace FlowBase\Resource;

abstract class AbstractResource implements ResourceInterface, \JsonSerializable
{
    protected $identifier = '';
    protected $searchIndexFields = [];
    protected $container = [];
    protected static $storageFields = [];

    public function __construct($identifier)
    {
        $this->identifier = $identifier;
    }

    public static function constructFromBase64(string $json)
    {
        $itemData = json_decode(base64_decode($json), true);
        $newItem = new static($itemData['identifier']);
        foreach ($itemData['container'] as $key => $datum) {
            $newItem->set($key, $datum);
        }

        return $newItem;
    }

    /**
     * @return string
     */
    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    /**
     * @param string $identifier
     * @return self
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
        return $this;
    }

    /**
     * @param $key
     * @return bool
     */
    public function has($key): bool
    {
        return array_key_exists($key, $this->container);
    }

    /**
     * @param $key
     * @param null $default
     * @return mixed|null
     */
    public function get($key, $default = null)
    {
        if ($this->has($key) === false) {
            return $default;
        }

        return $this->container[$key];
    }

    /**
     * @param $key
     * @param $value
     * @param bool $overwrite
     * @return $this
     * @throws \Exception
     */
    public function set($key, $value, $overwrite = false)
    {
        if ($overwrite === false && $this->has($key)) {
            throw new \Exception('Key "' . $key . '" already exists', 1577393381);
        }
        $this->container[$key] = $value;

        return $this;
    }

    public function getSearchIndex(): string
    {
        $indexFields = [];
        array_push($indexFields, $this->identifier);
        foreach ($this->container as $datum) {
            array_push($indexFields, $datum);
        }

        $index = implode(' ', $indexFields);
        $index = preg_replace("/[^A-Za-z0-9]+/", ' ', $index);
        $index = mb_strtoupper($index);

        return $index;
    }

    public static function getStorageFields(): array
    {
        return self::$storageFields;
    }

    public function jsonSerialize(): array
    {
        return array_filter(get_object_vars($this));
    }
}