<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('booking_room', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->cascadeOnDelete();
            $table->foreignId('room_id')->constrained()->cascadeOnDelete();

            // prevent duplicate room in same booking
            $table->unique(['booking_id', 'room_id']);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_room');
    }
};
