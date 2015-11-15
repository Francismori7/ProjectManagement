<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->char('id', 36);
            $table->string('task');
            $table->char('project_id', 36);
            $table->char('employee_id', 36)->nullable();
            $table->char('host_id', 36)->nullable();
            $table->boolean('completed')->default(0);
            $table->timestamp('due_at')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('employee_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('host_id')->references('id')->on('users')->onDelete('set null');

            $table->primary('id');
            $table->index('project_id');
            $table->index('employee_id');
            $table->index('host_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tasks');
    }
}
