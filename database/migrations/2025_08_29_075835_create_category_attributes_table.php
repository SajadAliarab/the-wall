<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('category_attributes', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('attribute_id');
            $table->timestamps();

            $table->primary(['category_id', 'attribute_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('category_attributes');
    }
};
