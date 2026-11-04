<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('event_questions', function (Blueprint $table) {
            $table->string('group_key', 60)->default('extra')->index();
            $table->string('placeholder')->nullable();
            $table->text('help_text')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('event_questions', function (Blueprint $table) {
            $table->dropIndex(['group_key']);
            $table->dropColumn(['group_key', 'placeholder', 'help_text']);
        });
    }
};
