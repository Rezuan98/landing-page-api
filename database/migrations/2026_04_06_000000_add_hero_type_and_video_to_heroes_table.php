<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('heroes', function (Blueprint $table) {
            $table->enum('hero_type', ['slider', 'video'])->default('slider')->after('is_active');
            $table->string('video')->nullable()->after('hero_type');
        });
    }

    public function down(): void
    {
        Schema::table('heroes', function (Blueprint $table) {
            $table->dropColumn(['hero_type', 'video']);
        });
    }
};
