<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactFavoritesTable extends Migration
{
    public function up()
    {
        Schema::create('contact_favorites', function (Blueprint $table) {
            $table->integer('user_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->integer('contact_id')->references('id')->on('contacts')->onDelete('CASCADE');
            $table->primary(['user_id', 'contact_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('contact_favorites');
    }
}
