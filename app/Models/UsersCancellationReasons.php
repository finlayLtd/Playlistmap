<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersCancellationReasons extends Model {

    use HasFactory;
    protected $table = 'users_cancellation_reasons';

    protected $fillable = ['user_id', 'plan_id', 'cancellation_reason'];
    
    

}
