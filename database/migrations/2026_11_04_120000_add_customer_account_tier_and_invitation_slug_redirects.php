<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->string('account_tier', 20)->default('free')->index();
        });

        Schema::create('invitation_slug_redirects', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('invitation_website_id')->constrained('invitation_websites')->cascadeOnDelete();
            $table->string('slug', 72)->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invitation_slug_redirects');
        Schema::table('users', function (Blueprint $table): void {
            $table->dropIndex(['account_tier']);
            $table->dropColumn('account_tier');
        });
    }
};
