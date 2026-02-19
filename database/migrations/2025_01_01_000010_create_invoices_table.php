<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('number')->unique();
            $table->date('date');
            $table->string('customer_name')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->decimal('tax', 12, 2)->default(0);
            $table->decimal('paid', 12, 2)->default(0);
            $table->text('notes')->nullable();
            $table->string('currency', 10)->default('IQD');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
