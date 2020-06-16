<?php

namespace LaravelBoilerplates\BaseBoilerplate\Models;

use Base;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Comment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'uuid', 'subject', 'body',
      'is_public', 'is_approved',
      'user_id'
    ];
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_public'   => 'boolean',
        'is_approved' => 'boolean',
    ];


    /**
     * Get all of the models that own comments.
     */
    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }
    /**
     * Get the commentor of this comment.
     */
    public function commentor()
    {
        return $this->belongsTo(get_class(Base::user()), 'user_id', 'id');
    }


    /**
     * Scope to only include approved comments.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }
    /**
     * Scope to only include public comments.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }


    /**
     * Approve a comment.
     */
    public function approve()
    {
        $this->update([
            'is_approved' => true,
        ]);

        return $this;
    }
    /**
     * Disapprove a comment.
     */
    public function disapprove()
    {
        $this->update([
            'is_approved' => false,
        ]);

        return $this;
    }
    /**
     * Make comment public.
     */
    public function makePublic()
    {
        $this->update(['is_public' => true]);

        return $this;
    }
    /**
     * Make comment private.
     */
    public function makePrivate()
    {
        $this->update(['is_public' => false]);

        return $this;
    }







    protected function getAuthModelName()
    {
        if (config('comments.user_model')) {
            return config('comments.user_model');
        }

        if (!is_null(config('auth.providers.users.model'))) {
            return config('auth.providers.users.model');
        }

        throw new Exception('Could not determine the commentator model name.');
    }

}
