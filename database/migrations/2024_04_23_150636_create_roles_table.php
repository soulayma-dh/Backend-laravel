<?php

use Illuminate\Database\Migrations\Migration;
use MongoDB\Laravel\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    protected $connection = 'mongodb';
    
    public function up(): void
    {
        Schema::connection('mongodb')->create('roles', function (Blueprint $collection) {
            $collection->foreignId('user_id'); // Utilisation de foreignId pour simuler une clé étrangère
            $collection->string('role');
            $collection->timestamps();
        });

        // Ajouter un index pour la colonne 'user_id' si nécessaire
        Schema::connection('mongodb')->collection('roles', function ($collection) {
            $collection->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mongodb')->dropIfExists('roles');
    }
};
