<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
  protected $fillable = [
      'name',
      'description',
      'datetime',
      'user_id',
      'category_id',
      'status_id',
  ];
}
