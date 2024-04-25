<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Example video title column
            $table->string('description'); // Example video description column
            $table->text('filename');
            $table->text('file_path');
            $table->integer('length');
            $table->boolean('is_public')->default(true);
            $table->unsignedBigInteger('user_id'); // Assuming 'userid' is an unsigned big integer
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
