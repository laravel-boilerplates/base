<?php

namespace LaravelBoilerplates\BaseBoilerplate;

use Illuminate\Http\Request;
use Illuminate\Routing\UrlGenerator;

class Base
{
    /**
     * Provide the currently configured User model for this application.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function user() {
      $userClass = config('auth.providers.users.model');

      return new $userClass;
    }

    /**
     * Return the global menu.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function menu() {
      return app('menu.base');
    }

    /**
     * Wrap the laravel route() helper with the configured route prefix.
     *
     * @return string
     */
    public static function route($prefix, $name, $parameters = [], $absolute = true) {
      $generator = app(UrlGenerator::class);
      $name = $prefix . '.' . $name;

      return $generator->route($name, $parameters, $absolute);
    }

    /**
     * Wrap the laravel request() helper with the configured route prefix.
     *
     * @return string
     */
    public static function requestIs($prefix, $pattern) {
        $pattern = $prefix . '/' . $pattern;

        return request()->is($pattern);
    }
}
