<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->foreignIdFor(User::class, 'creator_id')->constrained('users', 'id')->cascadeOnDelete();
            $table->foreignIdFor(User::class, "assignee_id")->nullable()->references('id')->on('users');
            $table->string('title');
            $table->text('description')->nullable();
            $table->dateTime('due')->nullable();
            $table->enum('priority', ['LOW', 'MEDIUM', 'HIGH'])->default('LOW');
            $table->enum('state', ['TODO', 'IN_PROGRESS', 'ON_HOLD', 'DONE'])->default('TODO');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
