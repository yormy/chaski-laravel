<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sent_emails_log', function (Blueprint $table) {
            $table->id();
            $table->integer('sent_email_id')->unsigned();
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('type');

            $table->timestamps();

            $table->foreign('sent_email_id')->references('id')->on('sent_emails');
        });
    }

    public function down()
    {
        Schema::dropIfExists('sent_emails_log');
    }
};
