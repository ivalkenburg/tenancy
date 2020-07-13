<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivityLogTable extends Migration
{
    /**
     * @return void
     */
    public function up()
    {
        Schema::connection(config('activitylog.database_connection'))->create(config('activitylog.table_name'), function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('log_name')->nullable()->index();
            $table->text('description');
            $table->uuid('subject_id')->nullable();
            $table->string('subject_type')->nullable();
            $table->uuid('causer_id')->nullable();
            $table->string('causer_type')->nullable();
            $table->json('properties')->nullable();
            $table->foreignUuid('tenant_id')->nullable()->references('id')->on('tenants')->onDelete('CASCADE');
            $table->timestamps();
            $table->index(['subject_id', 'subject_type']);
            $table->index(['causer_id', 'causer_type']);
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::connection(config('activitylog.database_connection'))->dropIfExists(config('activitylog.table_name'));
    }
}
