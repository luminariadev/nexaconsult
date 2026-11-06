<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('landing_pages', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->index();
            $table->string('project_id')->nullable()->index();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('html_content');
            $table->string('theme_color')->default('purple');
            $table->string('whatsapp_number')->nullable();
            $table->string('status')->default('published'); // published, draft
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('landing_pages');
    }
};
