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
        //Fiyatlar KDV hariç, Genel Toplam KDV Dahil
        Schema::create('service_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade');
            $table->foreignId('product_id')->nullable()->constrained('products')->onDelete('set null');
            $table->string('product_name');
            $table->enum('product_type', array_column(\App\Enums\Product\TypeEnum::cases(), 'value'))
                ->default(\App\Enums\Product\TypeEnum::PRODUCT->value)
                ->nullable();
            $table->foreignId('unit_id');
            $table->integer('order')->default(1);
            $table->decimal('quantity', 18, 6)->default(0);
            $table->decimal('price', 18, 6)->default(0);
            $table->float('vat_rate', 5, 2)->default(0)->nullable();
            $table->decimal('sub_total', 18, 6)->default(0);
            $table->decimal('vat_total', 18, 6)->default(0);
            $table->decimal('total', 18, 6)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_items');
    }
};