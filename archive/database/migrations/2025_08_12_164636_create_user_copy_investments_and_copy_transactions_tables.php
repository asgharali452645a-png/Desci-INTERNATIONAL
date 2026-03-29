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
        Schema::create('user_copy_investments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('copy_trader_id');
            $table->decimal('investment_amount', 15, 2); 
            $table->decimal('fee_percentage', 5, 2); 
            $table->decimal('fee_amount', 15, 2); 
            $table->decimal('net_investment', 15, 2); 
            $table->decimal('min_profit_percentage', 5, 2); 
            $table->decimal('max_profit_percentage', 5, 2); 
            $table->dateTime('start_date')->default(now());
            $table->enum('status', ['active', 'closed', 'pending'])->default('pending');
            $table->integer('period_days')->nullable()->comment('Duration of investment in days (e.g., 7, 10, 30)');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('copy_trader_id')->references('id')->on('copy_traders')->onDelete('cascade');
            $table->index('user_id');
            $table->index('copy_trader_id');
        });

        Schema::create('copy_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_investment_id');
            $table->enum('type', ['investment', 'fee', 'profit', 'withdrawal']);
            $table->decimal('amount', 15, 2); 
            $table->decimal('profit_percentage', 5, 2)->nullable(); 
            $table->dateTime('transaction_date')->default(now());
            $table->timestamps();

            // Yahan badlao kiya gaya hai: 'user_investments' ko 'user_copy_investments' kar diya gaya hai
            $table->foreign('user_investment_id')->references('id')->on('user_copy_investments')->onDelete('cascade');
            $table->index('user_investment_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('copy_transactions');
        Schema::dropIfExists('user_copy_investments');
    }
};