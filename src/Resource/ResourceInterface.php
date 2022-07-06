<?php

namespace FlowBase\Resource;

interface ResourceInterface
{


    public function __construct($identifier);

    /**
     * @param string $json
     * @return static
     */
    public static function constructFromBase64(string $json);

    /**
     * @return string
     */
    public function getIdentifier(): string;

    /**
     * @param string $identifier
     * @return $this
     */
    public function setIdentifier($identifier);

    /**
     * @param string $key
     * @param mixed $value
     * @param bool $overwrite
     * @return $this
     */
    public function set(string $key, $value, $overwrite = false);

    /**
     * @param string $key
     * @param null $default
     * @return mixed|null
     */
    public function get(string $key, $default = null);

    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool;

    public function getSearchIndex(): string;

    public static function getStorageFields(): array;

    public function jsonSerialize(): array;
}