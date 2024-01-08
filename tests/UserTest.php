<?php

namespace Test;

use Test\CustomException;

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

    public static function staticCall()
    {
        throw new CustomException("Error Processing Request");
    }
}
