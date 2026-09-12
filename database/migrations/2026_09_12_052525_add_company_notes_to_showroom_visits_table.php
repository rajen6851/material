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
        Schema::table('showroom_visits', function (Blueprint $table) {
            $table->string('email')->nullable()->after('mobile');
            $table->string('company_name')->nullable()->after('role');
            $table->text('notes')->nullable()->after('purpose');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('showroom_visits', function (Blueprint $table) {
            $table->dropColumn(['email', 'company_name', 'notes']);
        });
    }
};
