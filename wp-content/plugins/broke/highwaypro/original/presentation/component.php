<?php

namespace HighWayPro\Original\Presentation;

use HighWayPro\Original\Environment\Env;

Class Component
{
    protected $file;

    public function render()
    {
        (object) $self = $this;

        include $this->templateFile();
    }

    /*
        Overridable by children components
    */
    public function directory()
    {
        return Env::directory() . 'app/views';
    }

    private function templateFile()
    {
        return "{$this->directory()}/".strtolower($this->file);
    }
}