<?php

namespace App\Core\Models;

use Illuminate\Contracts\Support\Arrayable as ArrayableContract;
use Illuminate\Contracts\Support\Jsonable as JsonableContract;
use LaravelDoctrine\ORM\Serializers\Arrayable;
use LaravelDoctrine\ORM\Serializers\Jsonable;

class BaseEntity implements JsonableContract, ArrayableContract
{
    use Jsonable, Arrayable;
}
