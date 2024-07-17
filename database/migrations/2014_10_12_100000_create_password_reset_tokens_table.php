<?php

use Illuminate\Database\Migrations\Migration;
use MongoDB\Laravel\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */


    public function up(): void
    {
        Schema::connection('mongodb')->create('password_reset_tokens', function (Blueprint $collection) {
            $collection->index('email');
            $collection->string('token');
            $collection->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mongodb')->dropIfExists('password_reset_tokens');
    }
};
