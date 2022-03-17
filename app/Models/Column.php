<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Column extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function cards()
    {
        return $this->hasMany(Card::class)->orderBy('display_order', 'ASC');
    }
}
