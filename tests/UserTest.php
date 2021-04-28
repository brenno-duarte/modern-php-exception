<?php

namespace Test;

class UserTest
{
    private $name;

    public function firstCall($name)
    {
        $this->name = $name;
    }

    public function secondCall()
    {
        $this->name = $name;
    }
}
