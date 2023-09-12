<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    protected $table='attendance';
    protected $fillable = [
        'course_id','attendance_date','student_id','student_presence_datetime','admin_id','status'
    ];
}
