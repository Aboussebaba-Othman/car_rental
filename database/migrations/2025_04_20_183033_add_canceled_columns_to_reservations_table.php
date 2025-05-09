<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCanceledColumnsToReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reservations', function (Blueprint $table) {
            if (!Schema::hasColumn('reservations', 'canceled_at')) {
                $table->timestamp('canceled_at')->nullable();
            }
            
            if (!Schema::hasColumn('reservations', 'canceled_by')) {
                $table->unsignedBigInteger('canceled_by')->nullable();
                $table->foreign('canceled_by')->references('id')->on('users')->onDelete('set null');
            }
            
            if (!Schema::hasColumn('reservations', 'cancellation_reason')) {
                $table->text('cancellation_reason')->nullable();
            }
            
            if (!Schema::hasColumn('reservations', 'confirmed_at')) {
                $table->timestamp('confirmed_at')->nullable();
            }
            
            if (!Schema::hasColumn('reservations', 'confirmed_by')) {
                $table->unsignedBigInteger('confirmed_by')->nullable();
                $table->foreign('confirmed_by')->references('id')->on('users')->onDelete('set null');
            }
            
            if (!Schema::hasColumn('reservations', 'completed_at')) {
                $table->timestamp('completed_at')->nullable();
            }
            
            if (!Schema::hasColumn('reservations', 'completed_by')) {
                $table->unsignedBigInteger('completed_by')->nullable();
                $table->foreign('completed_by')->references('id')->on('users')->onDelete('set null');
            }
        });
    }

    
    public function down()
    {
        Schema::table('reservations', function (Blueprint $table) {
            if (Schema::hasColumn('reservations', 'canceled_at')) {
                $table->dropColumn('canceled_at');
            }
            
            if (Schema::hasColumn('reservations', 'canceled_by')) {
                $table->dropForeign(['canceled_by']);
                $table->dropColumn('canceled_by');
            }
            
            if (Schema::hasColumn('reservations', 'cancellation_reason')) {
                $table->dropColumn('cancellation_reason');
            }
            
            if (Schema::hasColumn('reservations', 'confirmed_at')) {
                $table->dropColumn('confirmed_at');
            }
            
            if (Schema::hasColumn('reservations', 'confirmed_by')) {
                $table->dropForeign(['confirmed_by']);
                $table->dropColumn('confirmed_by');
            }
            
            if (Schema::hasColumn('reservations', 'completed_at')) {
                $table->dropColumn('completed_at');
            }
            
            if (Schema::hasColumn('reservations', 'completed_by')) {
                $table->dropForeign(['completed_by']);
                $table->dropColumn('completed_by');
            }
        });
    }
}