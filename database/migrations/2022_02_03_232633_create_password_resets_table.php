<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePasswordResetsTable extends Migration
{
    public function up()
    {
        Schema::create('password_resets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('token');
            $table->timestamp('created_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('password_resets');
    }
}
