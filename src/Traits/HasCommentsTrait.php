<?php

namespace LaravelBoilerplates\BaseBoilerplate\Traits;

use LaravelBoilerplates\BaseBoilerplate\Models\Comment;

trait HasCommentsTrait {
  /**
   * Return all comments for this model.
   *
   * @return MorphMany
   */
  public function comments()
  {
      return $this->morphMany(Comment::class, 'commentable');
  }
}
