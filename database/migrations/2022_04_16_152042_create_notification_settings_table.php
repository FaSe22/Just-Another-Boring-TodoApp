<?php

use App\Models\Task;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Task::class)->nullable()->constrained()->cascadeOnDelete();
            $table->boolean('on_creation')->default(false);
            $table->boolean('on_assignment')->default(true);
            $table->boolean('one_day_before_deadline')->default(true);
            $table->boolean('comment_on_your_task')->default(true);
            $table->boolean('on_state_change')->default(false);
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
        Schema::dropIfExists('notification_settings');
    }
}
