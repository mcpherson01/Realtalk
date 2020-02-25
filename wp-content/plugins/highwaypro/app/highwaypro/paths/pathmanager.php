<?php

namespace HighWayPro\App\HighWayPro\Paths;

use HighwayPro\Original\Characters\StringManager;

Class PathManager
{
    protected $path;

    public static function getValidPathMessage()
    {
        return new StringManager(
            'Valid paths start with a slash followed by one or more '.
            'letters and/or numbers optionally separated by one or more '.
            'dashes. Spaces are not allowed.'
        );
    }
    
    public function __construct($path)
    {
        $this->rawPath = (new StringManager($path));
        $this->path = (new StringManager($path))->trim();
    }

    public function getClean()
    {
        if ((strlen($this->path->get()) > 0) && (strpos($this->path->get(), '/') === false)) {
            return "/{$this->path->get()}";
        } elseif (substr($this->path->get(), strlen($this->path->get()) -1) === '/') {
            (string) $noLeadingSlash = strpos($this->path->get(), '/') === 0? substr($this->path->get(), 1) : $this->path->get();
            (string) $noTrailingSlash = substr($noLeadingSlash, 0, strlen($noLeadingSlash) - 1);

            return "/{$noTrailingSlash}";
        }

        return $this->path->get();
    }

    public function formatIsValid()
    {
        return $this->rawPath->startsWith('/') &&
               (!$this->rawPath->endsWith('/')) && 
                $this->rawPath->trimLeft('/')->matches('/^([A-Za-z0-9-]+)$/');
    }
}
