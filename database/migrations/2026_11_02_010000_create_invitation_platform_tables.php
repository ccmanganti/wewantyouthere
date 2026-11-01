<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void {
  Schema::create('event_types',function(Blueprint $t){$t->id();$t->string('name')->unique();$t->string('slug')->unique();$t->boolean('is_active')->default(true);$t->timestamps();});
  Schema::create('event_questions',function(Blueprint $t){$t->id();$t->foreignId('event_type_id')->constrained()->cascadeOnDelete();$t->string('key');$t->string('label');$t->string('type')->default('text');$t->json('options')->nullable();$t->boolean('is_required')->default(false);$t->boolean('is_enabled')->default(true);$t->unsignedInteger('sort_order')->default(0);$t->timestamps();$t->unique(['event_type_id','key']);});
  Schema::create('invitation_templates',function(Blueprint $t){$t->id();$t->foreignId('event_type_id')->constrained()->restrictOnDelete();$t->foreignId('creator_id')->nullable()->constrained('users')->nullOnDelete();$t->string('name');$t->string('slug')->unique();$t->string('code_path')->nullable();$t->string('thumbnail_path')->nullable();$t->string('status')->default('draft');$t->boolean('is_premium')->default(false);$t->unsignedInteger('version')->default(1);$t->json('settings')->nullable();$t->timestamps();});
  Schema::create('invitation_websites',function(Blueprint $t){$t->id();$t->foreignId('user_id')->constrained()->cascadeOnDelete();$t->foreignId('invitation_template_id')->constrained()->restrictOnDelete();$t->string('name');$t->string('slug')->unique();$t->string('custom_domain')->nullable()->unique();$t->string('domain_status')->default('unverified');$t->string('status')->default('draft');$t->json('answers')->nullable();$t->timestamps();});
 }
 public function down(): void {Schema::dropIfExists('invitation_websites');Schema::dropIfExists('invitation_templates');Schema::dropIfExists('event_questions');Schema::dropIfExists('event_types');}
};