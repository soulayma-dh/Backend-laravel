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
        Schema::connection('mongodb')->create('oauth_access_tokens', function (Blueprint $collection) {
            $collection->string('id', 100)->primary();
            $collection->index('user_id');
            $collection->unsignedBigInteger('user_id')->nullable();
            $collection->unsignedBigInteger('client_id');
            $collection->string('name')->nullable();
            $collection->text('scopes')->nullable();
            $collection->boolean('revoked');
            $collection->timestamps();
            $collection->dateTime('expires_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mongodb')->dropIfExists('oauth_access_tokens');
    }

};
