<?php

namespace App\Models;

use App\Traits\Model\ScopeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insistence extends Model
{
    use HasFactory, ScopeTrait;

    protected $fillable = [];

    public function scopeStatus($query, $statuses)
    {
        if (empty($statuses)) {
            return $query;
        }

        return $query->whereIn('status', $statuses);
    }
}
