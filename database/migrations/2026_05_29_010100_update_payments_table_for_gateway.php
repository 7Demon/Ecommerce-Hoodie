<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // Gateway info
            $table->string('gateway_provider')->nullable()->after('order_id');
            $table->string('gateway_reference')->nullable()->after('gateway_provider');
            $table->string('payment_url')->nullable()->after('payment_method');
            $table->string('snap_token')->nullable()->after('payment_url');

            // Make amount nullable change not needed – already exists
            // Add payload JSON for raw webhook data
            $table->json('payload')->nullable()->after('status');

            // Status timestamps
            $table->timestamp('paid_at')->nullable()->after('payload');
            $table->timestamp('expired_at')->nullable()->after('paid_at');
            $table->timestamp('failed_at')->nullable()->after('expired_at');
        });

        // Expand status enum values
        // We'll handle this by modifying the column type to string for flexibility
        Schema::table('payments', function (Blueprint $table) {
            $table->string('status', 20)->default('pending')->change();
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn([
                'gateway_provider',
                'gateway_reference',
                'payment_url',
                'snap_token',
                'payload',
                'paid_at',
                'expired_at',
                'failed_at',
            ]);
        });
    }
};
