<?php

namespace App\Models;

class Tenant extends \Illuminate\Database\Eloquent\Model
{
    protected $primaryKey = 'id';

    protected $table = 'tenant';

    public $incrementing = false;

    protected $keyType = 'string';

}
