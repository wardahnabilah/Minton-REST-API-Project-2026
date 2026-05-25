<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourtSchedule extends Model
{
    use SoftDeletes;

    protected $fillable = ['court_id', 'day', 'open_time', 'close_time', 'created_by', ];

    public function court() {
        return $this->belongsTo(Court::class, 'court_id', 'id');
    }
}
