<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->text('title'); // Used only to reference the post in admin section (like the name of the post)
            $table->text('title_meta'); // Used for SEO
            $table->text('slug');
            $table->longText('content');
            $table->string('status')->default('awaiting-review');
            $table->string('visibility')->default('public');
            $table->integer('allow_comments')->default(1);
            $table->integer('allow_reactions')->default(1);
            $table->integer('comments_count')->default(0);
            $table->integer('reactions_count')->default(0);
            $table->text('summary')->nullable();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');

            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->json('metadata')->nullable();
            // Soft delete
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
