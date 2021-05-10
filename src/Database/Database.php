<?php

namespace App\Database;

use Illuminate\Database\Capsule\Manager as Capsule;

class Database
{
    public function __construct()
    {
        $capsule = new Capsule();

        $capsule->addConnection([
            'driver'    => settings('db.connection'),
            'host'      => settings('db.host'),
            'database'  => settings('db.name'),
            'username'  => settings('db.username'),
            'password'  => settings('db.password'),
            'charset'   => 'utf8',
            'collation' => 'utf8_general_ci',
            'prefix'    => '',
        ]);

        $capsule->setAsGlobal();

        $capsule->bootEloquent();
    }
}
