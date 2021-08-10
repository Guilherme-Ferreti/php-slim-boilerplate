<?php

namespace App\Collections;

use Ramsey\Collection\AbstractCollection;

abstract class BaseCollection extends AbstractCollection
{
    public function load(...$relations): self
    {
        foreach ($relations as $relation) {
            $this->{'load' . ucwords($relation)}();
        }
        
        return $this;
    }
}
