<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model {

    protected $table = 'options';
    protected $fillable = [
        'id', 'option_key', 'option_value'
    ];

    public static function  getByKey($key) {
        
    }

}
