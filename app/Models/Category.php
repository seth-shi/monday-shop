<?php

namespace App\Models;

use Baum\Node;

/**
* Category
*/
class Category extends Node
{

  protected $table = 'categories';

  protected $guarded = array('id', 'parent_id', 'lft', 'rgt', 'depth');

}
