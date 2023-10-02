<?php

namespace App\Models;

use App\Traits\Model\ScopeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exam extends Model
{
    use HasFactory, ScopeTrait, SoftDeletes;

    protected $guarded = [];
}
