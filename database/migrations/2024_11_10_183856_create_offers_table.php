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
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique()->nullable();
            $table->foreignId('customer_id')->nullable()->constrained('customers')->onDelete('set null');
            $table->text('description')->nullable();
            foreach (range(1, 5) as $i) {
                $table->foreignId("special_group{$i}_id")->nullable()->constrained('groups')->onDelete('set null');
            }
            $table->timestamp('date')->nullable();
            $table->timestamp('validity_date')->nullable();
            $table->enum('stage', array_column(\App\Enums\Offer\StageEnum::cases(), 'value'))
                ->default((string)\App\Enums\Offer\StageEnum::OFFER->value)
                ->nullable();
            $table->enum('status', array_column(\App\Enums\Offer\StatusEnum::cases(), 'value'))
                ->default((string)\App\Enums\Offer\StatusEnum::PROCESSING->value)
                ->nullable();
            //İskonto düşülmüş, kdv dahil items stok toplamı
            $table->decimal('stock_total', 18, 6)->default(0);
            //İskonto düşülmüş, kdv dahil items hizmet toplamı
            $table->decimal('service_total', 18, 6)->default(0);
            $table->decimal('discount_total', 18, 6)->default(0);
            //İskonto düşülmüş, kdv hariç toplam
            $table->decimal('sub_total', 18, 6)->default(0);
            //Kdv toplam
            $table->decimal('vat_total', 18, 6)->default(0);
            //Fatura toplam
            $table->decimal('total', 18, 6)->default(0);
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('approved_date')->nullable();
            $table->foreignId('cancelled_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('cancelled_date')->nullable();
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
        Schema::dropIfExists('offers');
    }
};
