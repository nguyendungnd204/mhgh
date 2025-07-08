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
        Schema::create('topup_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_code')->unique();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('server_name');
            $table->string('character_name');
            $table->string('card_type');
            $table->integer('amount');
            $table->string('serial');
            $table->string('card_code');
            $table->enum('status', ['pending', 'success', 'failed'])->default('pending');
            $table->text('response_content')->nullable();
            $table->timestamp('submitted_at');
            $table->timestamp('verified_at')->nullable();
            $table->boolean('is_manual')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('topup_transactions');
    }
};
