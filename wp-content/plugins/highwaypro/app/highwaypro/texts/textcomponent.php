<?php

namespace HighWayPro\App\HighWayPro\Texts;

Abstract Class TextComponent
{
    private $texts;

    abstract protected static function registerTexts(); /* : Collection*/

    public function __construct()
    {
        $this->texts = $this->registerTexts();
    }

    public function getTexts()
    {
        return $this->texts;
    }
}