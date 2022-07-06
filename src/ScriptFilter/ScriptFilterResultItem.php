<?php

namespace FlowBase\ScriptFilter;

use FlowBase\Utility\Debugger;

class ScriptFilterResultItem implements \JsonSerializable
{

    /**
     * This is a unique identifier for the item which allows help Alfred to
     * learn about this item for subsequent sorting and ordering of the user's
     * actioned results.
     *
     * It is important that you use the same UID throughout subsequent
     * executions of your script to take advantage of Alfred's knowledge and
     * sorting. If you would like Alfred to always show the results in the
     * order you return them from your script, exclude the UID field.
     *
     * @var string
     */
    protected $uid = null;

    /**
     * The title displayed in the result row. There are no options for this
     * element and it is essential that this element is populated.
     *
     * @var string
     */
    protected $title;


    /**
     * The subtitle displayed in the result row. This element is optional.
     * @var null|string
     */
    protected $subtitle = null;

    /**
     * The argument which is passed through the workflow to the connected
     * output action.
     *
     * While the arg attribute is optional, it's highly recommended that you
     * populate this as it's the string which is passed to your connected
     * output actions. If excluded, you won't know which result item the user
     * has selected.
     *
     * @var null|string
     */
    protected $argument = null;


//    protected $valid = true;
//    protected $autocomplete;
//    protected $icon;
//    protected $type;
//    protected $text = [];
//    protected $quicklookurl;
//    protected $mods = [];

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     * @return ScriptFilterResultItem
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getUid(): ?string
    {
        return $this->uid;
    }

    /**
     * @param string $uid
     * @return ScriptFilterResultItem
     */
    public function setUid(?string $uid): ScriptFilterResultItem
    {
        $this->uid = $uid;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSubtitle(): ?string
    {
        return $this->subtitle;
    }

    /**
     * @param string|null $subtitle
     * @return ScriptFilterResultItem
     */
    public function setSubtitle(?string $subtitle): ScriptFilterResultItem
    {
        $this->subtitle = $subtitle;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getArgument(): ?string
    {
        return $this->argument;
    }

    /**
     * @param string|null $argument
     * @return ScriptFilterResultItem
     */
    public function setArgument(?string $argument): ScriptFilterResultItem
    {
        $this->argument = $argument;
        return $this;
    }




    public function jsonSerialize()
    {
        $result = [];

        if($this->getUid() !== null){
            $result['uid'] = $this->getUid();
        }

        $result['title'] = $this->getTitle();

        if($this->getSubtitle() !== null){
            $result['subtitle'] = $this->getSubtitle();
        }
        if($this->getArgument() !== null){
            $result['arg'] = $this->getArgument();
        }

        return $result;
    }


}
