<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->char('cpf', 11)->unique();
            $table->string('email')->unique();
            $table->string('username')->unique()->nullable();
            $table->string('full_name');
            $table->string('password');
            $table->string('phone_number');
            $table->timestamps();
        });

        /*$userOne = [
            'cpf' => '11111111111',
            'email' => 'huguinho.duck@email.com',
            'full_name' => 'Huguinho Duck',
            'password' => 'huey',
            'phone_number' => '(11) 1111-1111',
        ];

        $userTwo = [
            'cpf' => '22222222222',
            'email' => 'zezinho.duck@email.com',
            'full_name' => 'Zezinho Duck',
            'password' => 'dewey',
            'phone_number' => '(11) 2222-2222',
        ];

        $userThree = [
            'cpf' => '33333333333',
            'email' => 'luisinho.duck@email.com',
            'full_name' => 'Luisinho Duck',
            'password' => 'louie',
            'phone_number' => '(11) 3333-3333',
        ];

        // Insert some stuff
        DB::table('users')->insert(
            $userOne,
            $userTwo,
            $userThree
        );*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
