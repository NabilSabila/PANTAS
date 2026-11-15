<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('notifikasi', function (Blueprint $t) {
            $t->string('dedupe_key')->nullable()->unique();
        });
    }

    public function down(): void
    {
        Schema::table('notifikasi', function (Blueprint $t) {
            $t->dropColumn('dedupe_key');
        });
    }
};
