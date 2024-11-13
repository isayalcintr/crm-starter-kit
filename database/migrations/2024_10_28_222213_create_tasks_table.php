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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique()->nullable();
            $table->foreignId('customer_id')->nullable()->constrained('customers')->onDelete('set null');
            $table->string('subject');
            $table->text('description')->nullable();
            $table->enum('priority', array_column(\App\Enums\Task\PriorityEnum::cases(), 'value'))
                ->default(\App\Enums\Task\PriorityEnum::NORMAL->value)
                ->nullable();
            $table->enum('status', array_column(\App\Enums\Task\StatusEnum::cases(), 'value'))
                ->default(\App\Enums\Task\StatusEnum::PROCESSING->value)
                ->nullable();
            $table->foreignId('category_id')->nullable()->constrained('groups')->onDelete('set null');
            foreach (range(1, 5) as $i) {
                $table->foreignId("special_group{$i}_id")->nullable()->constrained('groups')->onDelete('set null');
            }
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->foreignId('incumbent_by')->nullable()->constrained('users')->onDelete('set null');
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
        Schema::dropIfExists('tasks');
    }
};
