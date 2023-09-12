<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $table='course';
    protected $fillable = [
        'course_name','module_id','admin_id','status'
    ];
}
