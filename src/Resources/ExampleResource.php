<?php

namespace App\Resources;

class ExampleResource extends BaseResource
{
    public static function toArray($example) : array
    {
        // Complex logic for parsing the model to array
        
        return parent::toArray($example);
    }
}
