<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table(
            'items',
            fn (Blueprint $table) => $table->text('reference')->nullable()->change()
        );
    }

    public function down(): void
    {
        Schema::table(
            'items',
            fn (Blueprint $table) => $table->string('reference')->nullable()->change()
        );
    }
};
