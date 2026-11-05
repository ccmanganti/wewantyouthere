<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('invitation_rsvps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invitation_website_id')->constrained('invitation_websites')->cascadeOnDelete();
            $table->string('guest_name', 120);
            $table->string('attendance', 16); // attending or declined
            $table->unsignedTinyInteger('guest_count')->default(0);
            $table->text('message')->nullable();
            $table->timestamps();
            $table->index(['invitation_website_id','attendance']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invitation_rsvps');
    }
};
