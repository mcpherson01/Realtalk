<?php

namespace HighWayPro\App\HighWayPro\Texts;

use HighWayPro\Original\Collections\Collection;

Abstract Class ApplicationText
{
    abstract protected static function register(); /* : Collection*/

    public function __construct()
    {
        $this->texts = new Collection([]);

        foreach (static::register()->asArray() as $TextComponent)  {
            (object) $textComponent = new $TextComponent;
            
            $this->texts->add($TextComponent::name, $textComponent->getTexts());
        }
    }

    public function getTexts()
    {
        return $this->texts;   
    }
    
}