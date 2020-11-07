<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateSellersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sellers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('account_id')->unsigned();
            $table->string('cnpj')->unique();
            $table->string('fantasy_name');
            $table->string('social_name');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('account_id')->references('id')->on('accounts');
        });

        /*$parameters = [
            'user_id' => 1,
            'username' => 'huguinhoduck',
            'cnpj' => '11111111111111',
            'fantasy_name' => 'Duck Pets',
            'social_name' => 'Duck Pets ltda',
        ];

        // Insert some stuff
        DB::table('sellers')->insert(
            $parameters
        );*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sellers');
    }
}
