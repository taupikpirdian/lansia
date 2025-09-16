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
        Schema::table('sliders', function (Blueprint $table) {
            $table->string('background_image')->nullable()->after('link');
            $table->string('background_image_url')->nullable()->after('background_image');
            $table->string('person1_image')->nullable()->after('background_image_url');
            $table->string('person1_image_url')->nullable()->after('person1_image');
            $table->string('person1_name')->nullable()->after('person1_image_url');
            $table->string('person1_position')->nullable()->after('person1_name');
            $table->string('person2_image')->nullable()->after('person1_position');
            $table->string('person2_image_url')->nullable()->after('person2_image');
            $table->string('person2_name')->nullable()->after('person2_image_url');
            $table->string('person2_position')->nullable()->after('person2_name');
            $table->string('person3_image')->nullable()->after('person2_position');
            $table->string('person3_image_url')->nullable()->after('person3_image');
            $table->string('person3_name')->nullable()->after('person3_image_url');
            $table->string('person3_position')->nullable()->after('person3_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sliders', function (Blueprint $table) {
            $table->dropColumn([
                'background_image',
                'background_image_url',
                'person1_image',
                'person1_image_url',
                'person1_name',
                'person1_position',
                'person2_image',
                'person2_image_url',
                'person2_name',
                'person2_position',
                'person3_image',
                'person3_image_url',
                'person3_name',
                'person3_position'
            ]);
        });
    }
};
