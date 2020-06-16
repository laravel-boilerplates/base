<?php

namespace LaravelBoilerplates\BaseBoilerplate\Traits;

use Ramsey\Uuid\Uuid;

trait HasUuidTrait {

    /**
     * Boot function from laravel.
     */
    protected static function bootHasUuid()
    {
        static::creating(function ($model) {
            $model->{$model->getRouteKeyName()} = $model->generateUuid();
        });
    }


    /**
     * The UUID version to use.
     *
     * @var int
     */
    protected $uuidVersion = 4;


    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'uuid';
    }
    /**
     * Generate a UUID for this model.
     *
     * @throws \Exception
     * @return string
     */
    protected function generateUuid(): string
    {
        switch ($this->uuidVersion) {
            case 1:
                return Uuid::uuid1()->toString();
            case 3:
                return Uuid::uuid3(Uuid::NAMESPACE_DNS, $this->toJson())->toString();
            case 4:
                return Uuid::uuid4()->toString();
            case 5:
                return Uuid::uuid5(Uuid::NAMESPACE_DNS, $this->toJson())->toString();
        }
        throw new Exception("UUID version [{$this->uuidVersion}] not supported.");
    }


    /**
     * Find a model by its uuid.
     *
     * @param  mixed  $uuid
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|static[]|static|null
     */
    public static function findByUuid($uuid)
    {
        return self::whereUuid($uuid)->first();
    }
    /**
     * Find a model by its uuid or throw an exception.
     *
     * @param  mixed  $uuid
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|static|static[]
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public static function findByUuidOrFail($uuid)
    {
        return self::whereUuid($uuid)->firstOrFail();
    }


    /**
     * Eloquent scope to look for a given UUID
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  String                                $uuid  The UUID to search for
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithUuid($query, $uuid)
    {
        return $query->where($this->getRouteKeyName(), $uuid);
    }
    /**
     * Eloquent scope to look for multiple given UUIDs
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  Array                                 $uuids  The UUIDs to search for
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithUuids($query, Array $uuids)
    {
        return $query->whereIn($this->getRouteKeyName(), $uuids);
    }
}
