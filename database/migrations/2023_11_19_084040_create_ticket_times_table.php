<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ticket_times', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('description', 255)->nullable();
            $table->time('time');
            $table->integer('quantity')->default(1);
            $table->decimal('price');
            $table->string('currency')->default('TRY');
            $table->boolean('enabled')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ticket_times', function (Blueprint $table) {
            $table->dropForeign(['ticket_id']);
        });
        Schema::dropIfExists('ticket_times');
    }
};
