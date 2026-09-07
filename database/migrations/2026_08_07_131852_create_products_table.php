<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('sku')->unique();
            $table->text('description')->nullable();
            $table->text('short_description')->nullable();
            $table->decimal('mrp', 10, 2);
            $table->decimal('price', 10, 2);
            $table->decimal('discount', 10, 2)->nullable();
            $table->decimal('gst_percent', 5, 2)->default(18);
            $table->integer('stock')->default(0);
            $table->decimal('rating', 3, 2)->default(0);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_trending')->default(false);
            $table->boolean('is_new')->default(true);

            // Relationships
            $table->foreignId('room_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('brand_id')->constrained()->onDelete('cascade');

            // Existing Specs
            $table->string('size')->nullable();
            $table->string('color')->nullable();
            $table->string('finish')->nullable();
            $table->string('material')->nullable();
            $table->string('thickness')->nullable();
            $table->string('coverage_area')->nullable();
            $table->string('water_absorption')->nullable();
            $table->string('warranty')->nullable();
            $table->string('delivery_time')->nullable();

            // Spreadsheet Import Columns
            $table->string('collection')->nullable();
            $table->string('sub_category')->nullable();
            $table->integer('width_mm')->nullable();
            $table->integer('height_mm')->nullable();
            $table->string('size_inch')->nullable();
            $table->decimal('area_tile_sqft', 8, 2)->nullable();
            $table->string('pattern_type')->nullable();
            $table->string('edge_type')->nullable();
            $table->integer('pieces_per_box')->nullable();
            $table->decimal('coverage_per_box_sqft', 8, 2)->nullable();
            $table->decimal('weight_per_box_kg', 8, 2)->nullable();
            $table->decimal('price_per_box', 10, 2)->nullable();
            $table->decimal('price_per_sqft', 10, 2)->nullable();
            $table->string('application_area')->nullable();
            $table->string('seo_meta_title')->nullable();
            $table->text('seo_meta_description')->nullable();
            $table->string('catalog_page')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
