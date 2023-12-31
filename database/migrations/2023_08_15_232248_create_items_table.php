<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('reference')->nullable();
            $table->unsignedInteger('quantity')->default(1);
            $table->double('price', 10, 2)->default(0.0);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_quotable')->default(false);
            $table->timestamps();
            $table->timestamp('last_signed_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
