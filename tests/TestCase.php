<?php

namespace Tests;

use Laravel\Lumen\Testing\TestCase as BaseTestCase;
use Laravel\Lumen\Testing\DatabaseMigrations;

abstract class TestCase extends BaseTestCase
{
    use DatabaseMigrations;

    /**
     * @var array
     */
    protected $userOne = [
        'cpf' => '11111111111',
        'email' => 'huguinho.duck@email.com',
        'full_name' => 'Huguinho Duck',
        'password' => 'huey',
        'phone_number' => '(11) 1111-1111',
    ];

    /**
     * @var array
     */
    protected $userTwo = [
        'cpf' => '22222222222',
        'email' => 'zezinho.duck@email.com',
        'full_name' => 'Zezinho Duck',
        'password' => 'dewey',
        'phone_number' => '(11) 2222-2222',
    ];

    /**
     * @var array
     */
    protected $userThree = [
        'cpf' => '33333333333',
        'email' => 'luisinho.duck@email.com',
        'full_name' => 'Luisinho Duck',
        'password' => 'louie',
        'phone_number' => '(11) 3333-3333',
    ];

    /**
     * @var array
     */
    protected $parameters = [
        'user_id' => 1,
        'username' => 'huguinhoduck',
        'cnpj' => '11111111111111',
        'fantasy_name' => 'Duck Pets',
        'social_name' => 'Duck Pets ltda',
    ];

    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__ . '/../bootstrap/app.php';
    }
}
