<?php

namespace Tests;

use App \ {
    User,
    Consumer,
    Seller
};

class UserTest extends TestCase
{

    public function missingFieldProvider()
    {
        return [
            'cpf' => ['cpf'],
            'email' => ['email'],
            'full_name' => ['full_name'],
            'password' => ['password'],
            'phone_number' => ['phone_number'],
        ];
    }

    /**
     * @test
     * @dataProvider missingFieldProvider
     */
    public function itTriesToCreateAUserWithAMissingField($missingField)
    {
        unset($this->userOne[$missingField]);

        $missingFieldForMessage = str_replace('_', ' ', $missingField);
        $this->post('/users', $this->userOne)
            ->seeStatusCode(422)
            ->seeJsonEquals([
                'code' => '422',
                'message' => "O campo {$missingFieldForMessage} é obrigatório.",
            ]);
    }

    /**
     * @test
     */
    public function itTriesToListTwoUsersWithoutFilter()
    {
        User::factory()->create($this->userOne);
        User::factory()->create($this->userTwo);

        $this->get('/users')
            ->seeStatusCode(200)
            ->seeJsonEquals([
                [
                    'id' => 1,
                    'cpf' => $this->userOne['cpf'],
                    'email' => $this->userOne['email'],
                    'full_name' => $this->userOne['full_name'],
                    'password' => $this->userOne['password'],
                    'phone_number' => $this->userOne['phone_number'],

                ],
                [
                    'id' => 2,
                    'cpf' => $this->userTwo['cpf'],
                    'email' => $this->userTwo['email'],
                    'full_name' => $this->userTwo['full_name'],
                    'password' => $this->userTwo['password'],
                    'phone_number' => $this->userTwo['phone_number'],

                ],
            ]);
    }

    /**
     * @test
     */
    public function itTriesToListOneUserWithFilter()
    {
        User::factory()->create($this->userOne);
        User::factory()->create($this->userTwo);

        $this->get('/users?q=zezinho')
            ->seeStatusCode(200)
            ->seeJsonEquals([
                [
                    'id' => 2,
                    'cpf' => $this->userTwo['cpf'],
                    'email' => $this->userTwo['email'],
                    'full_name' => $this->userTwo['full_name'],
                    'password' => $this->userTwo['password'],
                    'phone_number' => $this->userTwo['phone_number'],

                ],
            ]);
    }

    /**
     * @test
     */
    public function itTriesToListNoUserWithFilter()
    {
        User::factory()->create($this->userOne);
        User::factory()->create($this->userTwo);

        $this->get('/users?q=UserNotExistent')
            ->seeStatusCode(200)
            ->seeJsonEquals([]);
    }

    /**
     * @test
     */
    public function itTriesToCreateAUser()
    {
        $this->post('/users', $this->userOne)
            ->seeStatusCode(200)
            ->seeJsonEquals([
                'id' => 1,
                'cpf' => $this->userOne['cpf'],
                'email' => $this->userOne['email'],
                'full_name' => $this->userOne['full_name'],
                'password' => $this->userOne['password'],
                'phone_number' => $this->userOne['phone_number'],
            ]);

        $this->seeInDatabase('users', [
            'id' => 1,
            'cpf' => $this->userOne['cpf'],
            'email' => $this->userOne['email'],
            'full_name' => $this->userOne['full_name'],
            'password' => $this->userOne['password'],
            'phone_number' => $this->userOne['phone_number'],
        ]);
    }

    /**
     * @test
     */
    public function itTriesToRetrieveOneSpecificUserWithTwoAccounts()
    {
        $this->userOne['username'] = 'huguinhoduck';

        $user = User::factory()->create($this->userOne);
        $user->consumer()->save(Consumer::factory()->make());
        $user->seller()->save(Seller::factory()->make([
            'cnpj' => $this->parameters['cnpj'],
            'fantasy_name' => $this->parameters['fantasy_name'],
            'social_name' => $this->parameters['social_name'],
        ]));

        $this->get('/users/1')
            ->seeStatusCode(200)
            ->seeJsonEquals([
                'accounts' => [
                    'consumer' => [
                        'id' => 1,
                        'user_id' => 1,
                        'username' => $this->userOne['username'],
                    ],
                    'seller' => [
                        'id' => 1,
                        'user_id' => 1,
                        'username' => $this->userOne['username'],
                        'cnpj' => $this->parameters['cnpj'],
                        'fantasy_name' => $this->parameters['fantasy_name'],
                        'social_name' => $this->parameters['social_name'],
                    ],
                    'user' => [
                        'id' => 1,
                        'cpf' => $this->userOne['cpf'],
                        'email' => $this->userOne['email'],
                        'full_name' => $this->userOne['full_name'],
                        'password' => $this->userOne['password'],
                        'phone_number' => $this->userOne['phone_number'],
                    ],
                ]
            ]);
    }

    /**
     * @test
     */
    public function itTriesToRetrieveOneSpecificUserWithJustASellerAccount()
    {
        $this->userOne['username'] = 'huguinhoduck';

        $user = User::factory()->create($this->userOne);
        $user->seller()->save(Seller::factory()->make([
            'cnpj' => $this->parameters['cnpj'],
            'fantasy_name' => $this->parameters['fantasy_name'],
            'social_name' => $this->parameters['social_name'],
        ]));

        $this->get('/users/1')
            ->seeStatusCode(200)
            ->seeJsonEquals([
                'accounts' => [
                    'seller' => [
                        'id' => 1,
                        'user_id' => 1,
                        'username' => $this->userOne['username'],
                        'cnpj' => $this->parameters['cnpj'],
                        'fantasy_name' => $this->parameters['fantasy_name'],
                        'social_name' => $this->parameters['social_name'],
                    ],
                    'user' => [
                        'id' => 1,
                        'cpf' => $this->userOne['cpf'],
                        'email' => $this->userOne['email'],
                        'full_name' => $this->userOne['full_name'],
                        'password' => $this->userOne['password'],
                        'phone_number' => $this->userOne['phone_number'],
                    ],
                ]
            ]);
    }

    /**
     * @test
     */
    public function itTriesToRetrieveAUnexistentUser()
    {
        $this->get('/users/1')
            ->seeStatusCode(404)
            ->seeJsonEquals([
                'code' => '404',
                'message' => 'Usuário não encontrado',
            ]);
    }
}
