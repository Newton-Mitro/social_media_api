<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrivaciesTable extends Migration
{
    public function up()
    {
        Schema::create('privacies', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('privacy_name');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('privacies');
    }
}
