<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('wedding_message_templates', function (Blueprint $table) {
            $table->id();
            $table->string('category', 50)->index();
            $table->text('content');
            $table->string('content_hash', 64);
            $table->timestamps();
            $table->unique(['category', 'content_hash']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wedding_message_templates');
    }
};
