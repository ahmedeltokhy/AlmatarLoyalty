<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToTransactionsTable extends Migration
{
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->unsignedBigInteger('user_from_id')->nullable();
            $table->foreign('user_from_id', 'user_from_fk_3569104')->references('id')->on('users');
            $table->unsignedBigInteger('user_to_id')->nullable();
            $table->foreign('user_to_id', 'user_to_fk_3569105')->references('id')->on('users');
        });
    }
}
