<?php

namespace App\DependencyInjection\Tests\Fixtures;

class DataBase
{
    public function __construct(string $dbUrl, string $dbName, string $dbUser, string $dbPassword)
    {
        //var_dump($dbUrl, $dbName, $dbUser, $dbPassword);
    }

}
