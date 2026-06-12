<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Court extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'created_by', 'updated_by'];

    public function court_schedule() {
        return $this->hasOne(CourtSchedule::class, 'court_id', 'id');
    }
}
