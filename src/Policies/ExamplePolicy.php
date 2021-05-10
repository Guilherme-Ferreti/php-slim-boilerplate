<?php

namespace App\Policies;

class ExamplePolicy
{
    public function view($user, $example) : bool
    {
        // Do authorization logic.

        return true;
    }
}
