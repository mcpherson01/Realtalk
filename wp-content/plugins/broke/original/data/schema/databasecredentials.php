<?php

namespace HighWayPro\Original\Data\Schema;

use HighWayPro\Original\Utilities\TypeChecker;

Class DatabaseCredentials
{
    use TypeChecker;

    protected $name;
    protected $host;
    protected $username;
    protected $password;

    public function __construct()
    {
        $credentials = (array) $this->set();

        $this->name = $credentials['name'];
        $this->host = $credentials['host'];
        $this->username = $credentials['username'];
        $this->password = $credentials['password'];
    }

    public function get($credential)
    {
        return $this->$credential;
    }
}