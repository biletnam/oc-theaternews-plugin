<?php namespace Abnmt\TheaterNews\Updates;

use October\Rain\Database\Updates\Migration;
use Schema;

class CreatePostsTable extends Migration
{

    public function up()
    {
        Schema::dropIfExists('abnmt_theaternews_posts');
        Schema::create('abnmt_theaternews_posts', function ($table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->string('title');
            $table->string('slug')->index();
            $table->text('content')->nullable()->default(null);
            $table->text('excerpt')->nullable()->default(null);

            $table->datetime('published_at')->nullable()->default(null);
            $table->boolean('published')->default(false);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('abnmt_theaternews_posts');
    }

}
