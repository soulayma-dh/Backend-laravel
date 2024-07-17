<?php

use Illuminate\Database\Migrations\Migration;
use MongoDB\Laravel\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.***
     */
    public function up(): void
    {
        Schema::connection('mongodb')->create('oauth_refresh_tokens', function (Blueprint $collection) {
            $collection->string('id', 100)->primary();
            $collection->index('access_token_id');
            $collection->string('access_token_id', 100);
            $collection->boolean('revoked');
            $collection->dateTime('expires_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mongodb')->dropIfExists('oauth_refresh_tokens');
    }
};