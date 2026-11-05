<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('invitation_templates', function (Blueprint $table) {
            $table->unsignedInteger('premium_price_cents')->default(99900);
            $table->char('premium_currency', 3)->default('PHP');
        });
        Schema::create('invitation_template_purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('invitation_template_id')->constrained()->restrictOnDelete();
            $table->unsignedInteger('amount_cents');
            $table->char('currency', 3)->default('PHP');
            $table->string('status', 20)->default('pending')->index();
            $table->string('provider', 30)->default('stripe');
            $table->string('provider_session_id')->nullable()->unique();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
            $table->index(['user_id', 'invitation_template_id', 'status'], 'invitation_purchase_access_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invitation_template_purchases');
        Schema::table('invitation_templates', function (Blueprint $table) {
            $table->dropColumn(['premium_price_cents', 'premium_currency']);
        });
    }
};
