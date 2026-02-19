<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('invoice_items', function (Blueprint $table) {
            // 'single' | 'box' | 'bottle' | 'kg' | 'liter' | 'other'
            $table->string('unit_type')->default('single')->after('unit_price');
            // for box: pieces per box; for bottle: litres per bottle
            $table->string('unit_detail')->nullable()->after('unit_type');
        });
    }

    public function down(): void
    {
        Schema::table('invoice_items', function (Blueprint $table) {
            $table->dropColumn(['unit_type', 'unit_detail']);
        });
    }
};
