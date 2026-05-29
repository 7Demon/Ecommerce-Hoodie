<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            // Snapshot product name so order history stays valid even if product changes
            $table->string('product_name')->after('product_id');
            $table->string('product_size')->nullable()->after('product_name');
            $table->string('product_color')->nullable()->after('product_size');
        });
    }

    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn(['product_name', 'product_size', 'product_color']);
        });
    }
};
