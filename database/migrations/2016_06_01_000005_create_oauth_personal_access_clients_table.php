<?php

use Illuminate\Database\Migrations\Migration;
use MongoDB\Laravel\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.****
     */
    public function up(): void
    {
        Schema::connection('mongodb')->create('oauth_personal_access_clients', function (Blueprint $collection) {
            $collection->bigIncrements('id');
            $collection->unsignedBigInteger('client_id');
            $collection->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mongodb')->dropIfExists('oauth_personal_access_clients');
    }
};
