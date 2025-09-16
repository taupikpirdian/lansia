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
        Schema::table('biodatas', function (Blueprint $table) {
            $table->string('no_nik')->nullable()->after('no_kk');
            $table->string('file_ktp')->nullable()->after('alamat');
            $table->string('file_ktp_url')->nullable()->after('file_ktp');
            $table->string('file_kk')->nullable()->after('file_ktp_url');
            $table->string('file_kk_url')->nullable()->after('file_kk');
            $table->string('file_ppks')->nullable()->after('file_kk_url');
            $table->string('file_ppks_url')->nullable()->after('file_ppks');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('biodatas', function (Blueprint $table) {
            $table->dropColumn(['no_nik', 'file_ktp', 'file_ktp_url', 'file_kk', 'file_kk_url', 'file_ppks', 'file_ppks_url']);
        });
    }
};
