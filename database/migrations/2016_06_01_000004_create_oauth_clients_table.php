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
        Schema::connection('mongodb')->create('oauth_clients', function (Blueprint $collection) {
            $collection->bigIncrements('id');
            $collection->index('user_id');
            $collection->unsignedBigInteger('user_id')->nullable();
            $collection->string('name');
            $collection->string('secret', 100)->nullable();
            $collection->string('provider')->nullable();
            $collection->text('redirect');
            $collection->boolean('personal_access_client');
            $collection->boolean('password_client');
            $collection->boolean('revoked');
            $collection->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mongodb')->dropIfExists('oauth_clients');
    }
};
