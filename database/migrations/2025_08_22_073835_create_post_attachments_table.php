<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('post_attachments', function (Blueprint $table) {
            $table->unsignedBigInteger('post_id');
            $table->unsignedBigInteger('attachment_id');
            $table->timestamps();

            $table->primary(['post_id', 'attachment_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('post_attachments');
    }
};
