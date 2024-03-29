<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DivisiModel extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $table = 'mst_divisi';
    protected $keyType = 'string';
}
