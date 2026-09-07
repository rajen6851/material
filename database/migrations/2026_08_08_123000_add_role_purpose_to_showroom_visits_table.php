<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('showroom_visits', function (Blueprint $table) {
            $table->string('role')->default('homeowner')->after('mobile'); // homeowner, professional
            $table->string('purpose')->nullable()->after('role'); // inspect, purchase, consultation, trade
        });
    }

    public function down(): void
    {
        Schema::table('showroom_visits', function (Blueprint $table) {
            $table->dropColumn(['role', 'purpose']);
        });
    }
};