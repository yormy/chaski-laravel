<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('mail_templates', function (Blueprint $table) {
            $table->string('xid')->after('id')->unique();
            $table->string('name')->after('xid')->nullable()->comment('Internal name for db inspection only');
            $table->boolean('to_admin_only')->default(false)->comment('sent to admins only'); //todo obsolete?
            $table->string('for_roles')->nullable()->comment('comma separated list of roles for which this notification could intented'); //todo obsolete?

            $table->string('tags')->nullable();
            $table->text('notes')->nullable();
            $table->string('html_layout')->nullable();
            $table->string('text_layout')->nullable();

            $table->boolean('mail_preventable')->default(true);
            $table->boolean('slack_preventable')->default(true);
            $table->boolean('sms_preventable')->default(true);
            $table->boolean('is_hidden')->default(false);
            $table->boolean('cannot_edit')->default(false);

            $table->string('notification')->nullable()->comment('notification class');
            $table->string('placeholders')->nullable()->comment('comma separated list of placeholders');  // TODO: still needed ?, getVariables?
        });
    }
};
