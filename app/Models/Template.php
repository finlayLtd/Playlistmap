<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    use HasFactory;

    protected $fillable = ['subject', 'body'];

    public function plans()
    {
        return $this->belongsToMany(Plan::class);
    }
}
