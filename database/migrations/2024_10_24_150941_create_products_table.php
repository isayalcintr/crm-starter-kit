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
        //Fiyatlar KDV hariç
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->foreignId('unit_id')->nullable();
            $table->float('purchase_vat_rate', 5, 2)->default(0)->nullable();
            $table->decimal('purchase_price', 18, 6)->default(0)->nullable();
            $table->float('sell_vat_rate', 5, 2)->default(0)->nullable();
            $table->decimal('sell_price', 18, 6)->default(0)->nullable();
            $table->decimal('quantity', 18, 6)->default(0)->nullable();
            foreach (range(1, 5) as $i) {
                $table->foreignId("special_group{$i}_id")->nullable()->constrained('groups')->onDelete('set null');
            }
            $table->enum('type', array_column(\App\Enums\Product\TypeEnum::cases(), 'value'))
                ->default(\App\Enums\Product\TypeEnum::PRODUCT->value)
                ->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('deleted_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
