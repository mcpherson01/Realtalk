<?php

namespace HighWayPro\App\Data\Model\Posts;

use HighWayPro\Original\Data\Model\Domain;

Class PostMeta extends Domain
{
    public function isEnabled()
    {
        return in_array($this->value, ['true', true], $strictTypes = true);   
    }

    public function hasValue()
    {
        if (is_string($this->value)) {
            return trim($this->value) !== '';
        } elseif (is_array($this->value)) {
            return $this->value !== [];
        } elseif (is_numeric($this->value)) {
            return true;
        }
    }

    public function getNumber()
    {
        return (integer) $this->value;   
    }
}