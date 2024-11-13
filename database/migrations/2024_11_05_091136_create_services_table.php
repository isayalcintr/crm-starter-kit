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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique()->nullable();
            $table->foreignId('customer_id')->nullable()->constrained('customers')->onDelete('set null');
            $table->text('description')->nullable();
            foreach (range(1, 5) as $i) {
                $table->foreignId("special_group{$i}_id")->nullable()->constrained('groups')->onDelete('set null');
            }
            $table->enum('status', array_column(\App\Enums\Service\StatusEnum::cases(), 'value'))
                ->default((string)\App\Enums\Service\StatusEnum::COMPLETED->value)
                ->nullable();
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            //İskonto düşülmüş, kdv dahil items stok toplamı
            $table->decimal('stock_total', 18, 6)->default(0);
            //İskonto düşülmüş, kdv dahil items hizmet toplamı
            $table->decimal('service_total', 18, 6)->default(0);
            //İskonto düşülmüş, kdv hariç toplam
            $table->decimal('sub_total', 18, 6)->default(0);
            //Kdv toplam
            $table->decimal('vat_total', 18, 6)->default(0);
            //Fatura toplam
            $table->decimal('total', 18, 6)->default(0);
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
        Schema::dropIfExists('services');
    }
};
