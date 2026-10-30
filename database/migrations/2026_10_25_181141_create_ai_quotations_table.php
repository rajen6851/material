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
        Schema::create('ai_quotations', function (Blueprint $table) {
            $table->id();
            $table->string('quote_number', 32)->unique();
            $table->enum('channel', ['website', 'whatsapp'])->default('website');
            $table->string('session_id', 128)->nullable()->index();
            $table->string('customer_name');
            $table->string('customer_phone', 32)->index();
            $table->string('customer_email')->nullable();
            $table->enum('customer_type', ['homeowner', 'professional', 'builder', 'unknown'])->default('homeowner');
            $table->text('delivery_address');
            $table->string('pincode', 10);
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('tax_total', 12, 2)->default(0);
            $table->decimal('discount_total', 12, 2)->default(0);
            $table->decimal('grand_total', 12, 2)->default(0);
            $table->text('customer_notes')->nullable();
            $table->enum('status', ['draft_pending', 'approved', 'rejected', 'sent', 'expired'])->default('draft_pending')->index();
            $table->foreignId('approved_by_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('approved_at')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->text('admin_notes')->nullable();
            $table->string('dispatch_status', 64)->default('pending');
            $table->json('dispatch_payload')->nullable();
            $table->timestamps();
        });

        Schema::create('ai_quotation_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ai_quotation_id')->constrained('ai_quotations')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('restrict');
            $table->string('product_name');
            $table->string('sku');
            $table->string('unit_type', 32)->default('box');
            $table->decimal('unit_price', 10, 2);
            $table->integer('quantity');
            $table->decimal('gst_percent', 5, 2)->default(18.00);
            $table->decimal('total_price', 12, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_quotation_items');
        Schema::dropIfExists('ai_quotations');
    }
};

