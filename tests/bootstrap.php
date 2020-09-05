<?php

use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__).'/vendor/autoload.php';

if (file_exists(dirname(__DIR__).'/config/bootstrap.php')) {
    require dirname(__DIR__).'/config/bootstrap.php';
} elseif (method_exists(Dotenv::class, 'bootEnv')) {
    (new Dotenv())->bootEnv(dirname(__DIR__).'/.env');
}

trait MockeryAssertions
{
    public function assertMockerySpy($mock)
    {
        try {
            $mock->verify();
            $result = true;
        } catch (Throwable $ex) {
            $result = false;
        }

        $this->assertTrue($result);
    }

    abstract public function assertTrue($assertion);
}