<?php

namespace FlowBase\ScriptFilter;


use FlowBase\ScriptFilter\ScriptFilterResultItem;
use FlowBase\Utility\Debugger;

class ScriptFilterResult implements \JsonSerializable
{

    protected $items = [];

    public function addNewItem(string $title, string $subtitle = null, string $uid = null)
    {
        $item = new ScriptFilterResultItem();
        $item->setTitle($title);
        $item->setSubtitle($subtitle);

        $this->items[] = $item;
        return $this;
    }

    public function addItem(ScriptFilterResultItem $item)
    {
        $this->items[] = $item;
        return $this;
    }

    public function jsonSerialize()
    {
        $result = [
            'items' => $this->items
        ];

        return $result;
    }

}
