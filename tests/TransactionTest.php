<?php

namespace Tests;

use App \ {
    User,
    Consumer,
    Seller,
    Transaction
};
use GuzzleHttp\ {
    Client,
    Handler\MockHandler,
    HandlerStack,
    Psr7\Response
};

class TransactionTest extends TestCase
{
    /**
     * @var array
     */
    protected $transaction;

    /**
     * @var int
     */
    protected $accountUserOne;

    /**
     * @var int
     */
    protected $accountUserTwo;

    /**
     * @inheritDoc
     */
    public function setUp(): void
    {
        parent::setUp();
        // register two consumers to transfer money between each other
        $userOne = User::factory()->create($this->userOne);
        $userOne->consumer()->save(Consumer::factory()->make());

        $userTwo = User::factory()->create($this->userTwo);
        $userTwo->consumer()->save(Consumer::factory()->make());

        $this->accountUserOne = $userOne->consumer->account->id;
        $this->accountUserTwo = $userTwo->consumer->account->id;
        $this->transaction = [
            'payee_id' => $this->accountUserOne,
            'payer_id' => $this->accountUserTwo,
            'value' => 50,
        ];
    }

    protected function createMockedResponse()
    {
        $mock = new MockHandler([
            new Response(200, [], ''),
        ]);
        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);
        $this->app->instance(Client::class, $client);
    }

    public function missingFieldProvider()
    {
        return [
            'payee_id' => ['payee_id'],
            'payer_id' => ['payer_id'],
            'value' => ['value'],
        ];
    }

    /**
     * @test
     * @dataProvider missingFieldProvider
     */
    public function itTriesToCreateATransactionWithAMissingField($missingField)
    {
        unset($this->transaction[$missingField]);

        $missingFieldForMessage = str_replace('_', ' ', $missingField);
        $this->post('/transactions', $this->transaction)
            ->seeStatusCode(422)
            ->seeJsonEquals([
                'code' => '422',
                'message' => "O campo {$missingFieldForMessage} é obrigatório.",
            ]);
    }

    /**
     * @test
     */
    public function itTriesToCreateATransactionBetweenExistentConsumersButWithTooHighValue()
    {
        $this->transaction['value'] = 500;
        $this->post('/transactions', $this->transaction)
            ->seeStatusCode(401)
            ->seeJsonEquals([
                'code' => '401',
                'message' => 'Transação não autorizada',
            ]);
    }

    /**
     * @test
     */
    public function itTriesToCreateATransactionBetweenExistentConsumers()
    {
        $this->createMockedResponse();
        $this->post('/transactions', $this->transaction)
            ->seeStatusCode(200)
            ->seeJson([
                'id' => 1,
                'payee_id' => $this->transaction['payee_id'],
                'payer_id' => $this->transaction['payer_id'],
                'value' => $this->transaction['value'],
            ]);

        $this->seeInDatabase('transactions', [
            'payee_id' => $this->transaction['payee_id'],
            'payer_id' => $this->transaction['payer_id'],
            'value' => $this->transaction['value'],
        ]);
    }

    /**
     * @test
     */
    public function itTriesToCreateATransactionBetweenAConsumerAndASeller()
    {
        $this->createMockedResponse();
        // register the seller
        $userThree = User::factory()->create($this->userThree);
        $userThree->seller()->save(Seller::factory()->make());
        $this->transaction['payee_id'] = $userThree->seller->account->id;

        $this->post('/transactions', $this->transaction)
            ->seeStatusCode(200)
            ->seeJson([
                'id' => 1,
                'payee_id' => $this->transaction['payee_id'],
                'payer_id' => $this->transaction['payer_id'],
                'value' => $this->transaction['value'],
            ]);

        $this->seeInDatabase('transactions', [
            'payee_id' => $this->transaction['payee_id'],
            'payer_id' => $this->transaction['payer_id'],
            'value' => $this->transaction['value'],
        ]);
    }

        /**
     * @test
     */
    public function itTriesToCreateATransactionBetweenASellerAndAConsummer()
    {
        $this->createMockedResponse();
        // register the seller
        $userThree = User::factory()->create($this->userThree);
        $userThree->seller()->save(Seller::factory()->make());
        $this->transaction['payer_id'] = $userThree->seller->account->id;

        $this->transaction['payee_id'] = $this->accountUserOne;

        $this->post('/transactions', $this->transaction)
            ->seeStatusCode(401)
            ->seeJsonEquals([
                'code' => '401',
                'message' => 'Transação não autorizada',
            ]);
    }

    /**
     * @test
     */
    public function itTriesToCreateATransactionBetweenNonExistentUsers()
    {
        $this->transaction['payee_id'] = 998;
        $this->transaction['payer_id'] = 999;

        $this->post('/transactions', $this->transaction)
            ->seeStatusCode(422)
            ->seeJsonEquals([
                'code' => '422',
                'message' => 'Uma das contas informadas não existe.',
            ]);
    }

    /**
     * @test
     */
    public function itTriesToRetrieveOneTransaction()
    {
        Transaction::factory()->create([
            'payee_id' => $this->accountUserOne,
            'payer_id' => $this->accountUserTwo,
            'value' => 50,
        ]);
        $this->get('/transactions/1')
            ->seeStatusCode(200)
            ->seeJson([
                'id' => 1,
                'payee_id' => $this->accountUserOne,
                'payer_id' => $this->accountUserTwo,
                'value' => 50,
            ]);
    }

    /**
     * @test
     */
    public function itTriesToRetrieveAUnexistentTransaction()
    {
        $this->get('/transactions/1')
            ->seeStatusCode(404)
            ->seeJsonEquals([
                'code' => '404',
                'message' => 'Transação não encontrada',
            ]);
    }
}
