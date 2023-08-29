<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table(
            'signatures',
            fn (Blueprint $table) => $table->foreignId('presence_id')
                ->after('id')
                ->nullable()
                ->constrained()
                ->nullOnDelete()
        );
    }

    public function down(): void
    {
        //
    }
};
