<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('mail_templates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mailable');
            $table->json('subject')->nullable();
            $table->json('summary')->nullable();
            $table->json('html_template');
            $table->json('text_template')->nullable();
            $table->json('notification_title');
            $table->json('notification_content')->nullable();
            $table->timestamps();
        });
    }
};
