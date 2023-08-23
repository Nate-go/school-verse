<?php

namespace App\Models;

use App\Traits\Model\ScopeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory, ScopeTrait;

    protected $fillable = [];

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }
}
