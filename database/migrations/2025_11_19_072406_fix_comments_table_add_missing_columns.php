<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('comments', function (Blueprint $table) {
           
            if (!Schema::hasColumn('comments', 'content')) {
                $table->text('content')->after('id');
            }

            if (!Schema::hasColumn('comments', 'post_id')) {
                $table->unsignedBigInteger('post_id')->after('content');
                $table->foreign('post_id')
                      ->references('id')
                      ->on('posts')
                      ->onDelete('cascade');
            }
        });
    }

    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            if (Schema::hasColumn('comments', 'post_id')) {
                $table->dropForeign(['post_id']);
                $table->dropColumn('post_id');
            }

            if (Schema::hasColumn('comments', 'content')) {
                $table->dropColumn('content');
            }
        });
    }
};