<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('sent_emails', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned()->nullable()->after('id');
            $table->string('user_type')->nullable()->after('user_id');

            $table->datetime('status_delivered_at')->nullable()->after('clicks');
            $table->text('status_complaint')->nullable()->after('status_delivered_at');
            $table->string('status_bounced')->nullable()->after('status_complaint');
            $table->string('status_delivered')->nullable()->after('status_bounced');

            $table->string('mailable_type')->nullable()->after('status_delivered');
        });
    }

    public function down()
    {
        //
    }
};
