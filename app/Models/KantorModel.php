<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KantorModel extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $table = 'mst_kantor';
    protected $keyType = 'string';
}
