<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookingTransaction extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id', 'court_schedule_id', 'date', 'start_time', 'end_time', 'status'];

    //
}
