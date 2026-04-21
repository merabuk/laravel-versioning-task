<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    private const string TABLE_NAME = 'versions';

    public function up(): void
    {
        Schema::create(self::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('versionable_id');
            $table->string('versionable_type', 50);

            $table->jsonb('snapshot');
            $table->integer('version');

            $table->timestamp('created_at')->useCurrent();

            $table->index(['versionable_id', 'versionable_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists(self::TABLE_NAME);
    }
};
