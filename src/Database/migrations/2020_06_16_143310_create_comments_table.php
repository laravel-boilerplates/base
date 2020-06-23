<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->text('subject');
            $table->text('body');
            $table->boolean('is_public')->default(true);
            $table->boolean('is_approved')->default(false);
            $table->timestamps();
        });

        Schema::create('commentable', function (Blueprint $table) {
            $table->integer('comment_id');
            $table->uuidMorphs('commentable');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
        Schema::dropIfExists('commentable');
    }
}
