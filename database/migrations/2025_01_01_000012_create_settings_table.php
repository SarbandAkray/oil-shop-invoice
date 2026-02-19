<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // Insert default values
        $defaults = [
            'company_name'     => 'Beston Oil',
            'company_address'  => 'صناعة الشمالية - مقابل كاكه جامچي',
            'company_phone'    => '0750 252 1551',
            'company_location' => '',
            'company_logo'     => '',   // empty = use public/logo.png
            'default_currency' => 'IQD',
        ];

        foreach ($defaults as $key => $value) {
            DB::table('settings')->insert(['key' => $key, 'value' => $value, 'created_at' => now(), 'updated_at' => now()]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
