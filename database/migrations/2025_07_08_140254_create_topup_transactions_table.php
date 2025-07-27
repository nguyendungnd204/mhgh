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
            $table->foreignId('user_character_id')->constrained('user_characters')->onDelete('cascade');
            $table->string('card_type');
            $table->integer('amount');
            $table->string('serial');
            $table->string('card_code');
            $table->enum('status', ['pending', 'success', 'failed'])->default('pending');
            $table->text('response_content')->nullable();
            $table->timestamp('submitted_at');
            $table->timestamp('verified_at')->nullable();
            $table->boolean('is_manual')->default(true);
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
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
