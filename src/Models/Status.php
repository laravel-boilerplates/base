<?php

namespace LaravelBoilerplates\BaseBoilerplate\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name', 'color'
  ];

  /**
   * Format the status name.
   *
   * @param  string  $name
   * @return string
   */
  public function getNameAttribute($name) : string {
    return Str::title($name);
  }


  /**
	 * Get the string content of the status.
	 */
  public function __toString() {
    return $this->name;
  }
}
