<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->string('payment_id')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('payment_status')->nullable();
            $table->decimal('amount_paid', 10, 2)->nullable();
            $table->dateTime('payment_date')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('payer_id')->nullable();
            $table->string('payer_email')->nullable();
            
            $table->dropColumn('status');
        });

        Schema::table('reservations', function (Blueprint $table) {
            $table->enum('status', ['pending', 'confirmed', 'canceled', 'completed', 'payment_pending', 'paid'])->default('pending');
        });
    }

   
    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn([
                'payment_id',
                'payment_method',
                'payment_status',
                'amount_paid',
                'payment_date',
                'transaction_id',
                'payer_id',
                'payer_email'
            ]);
            
            $table->dropColumn('status');
        });

        Schema::table('reservations', function (Blueprint $table) {
            $table->enum('status', ['pending', 'confirmed', 'canceled', 'completed'])->default('pending');
        });
    }
};
