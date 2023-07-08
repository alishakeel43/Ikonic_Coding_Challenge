<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('connections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sender_user_id')->constrained('users','id')->onDelete('cascade');
            $table->foreignId('receiver_user_id')->constrained('users','id')->onDelete('cascade');
            $table->enum('status', ['pending', 'approved'])->default('pending');
            $table->unique(['sender_user_id', 'receiver_user_id', 'status']);
            $table->timestamps();
        });

        // Add the constraint for check same user ids
        DB::statement('ALTER TABLE connections ADD CONSTRAINT chk_same_user_id CHECK (sender_user_id <> receiver_user_id );');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('connections');
    }
};
