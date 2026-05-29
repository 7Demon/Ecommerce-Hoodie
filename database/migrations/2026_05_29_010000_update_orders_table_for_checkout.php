<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Make user_id nullable for guest checkout
            $table->unsignedBigInteger('user_id')->nullable()->change();

            // Unique order number
            $table->string('order_number')->unique()->after('id');

            // Shipping details
            $table->string('shipping_courier')->nullable()->after('shipping_cost');
            $table->string('shipping_service')->nullable()->after('shipping_courier');
            $table->string('tracking_number')->nullable()->after('shipping_service');

            // Status timestamps
            $table->timestamp('paid_at')->nullable()->after('status');
            $table->timestamp('shipped_at')->nullable()->after('paid_at');
            $table->timestamp('delivered_at')->nullable()->after('shipped_at');
            $table->timestamp('cancelled_at')->nullable()->after('delivered_at');
        });

        // Fix typo: subttotal → subtotal (rename column)
        if (Schema::hasColumn('orders', 'subttotal') && !Schema::hasColumn('orders', 'subtotal')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->renameColumn('subttotal', 'subtotal');
            });
        }
    }

    public function down(): void
    {
        // Rename back
        if (Schema::hasColumn('orders', 'subtotal') && !Schema::hasColumn('orders', 'subttotal')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->renameColumn('subtotal', 'subttotal');
            });
        }

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'order_number',
                'shipping_courier',
                'shipping_service',
                'tracking_number',
                'paid_at',
                'shipped_at',
                'delivered_at',
                'cancelled_at',
            ]);
        });
    }
};
