<?php

namespace App\Models;

class User extends BaseModel
{
    public function posts()
    {
        return new Post(['user_id' => $this->id]);
    }
}
