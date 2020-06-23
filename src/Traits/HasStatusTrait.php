<?php

namespace LaravelBoilerplates\BaseBoilerplate\Traits;

use LaravelBoilerplates\BaseBoilerplate\Models\Status;

trait HasCommentsTrait {
  /**
   * Return all comments for this model.
   *
   * @return MorphMany
   */
  public function statuses()
  {
      return $this->morphMany(Status::class, 'statusable')->orderBy('created_at', 'desc');
  }
}
