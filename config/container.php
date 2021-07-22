<?php

use App\Repositories\Sql\UserRepository;
use App\Repositories\Interfaces\UserRepositoryInterface;

return [
    UserRepositoryInterface::class => \DI\autowire(UserRepository::class),
];
