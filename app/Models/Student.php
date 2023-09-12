<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $table='student';
    protected $fillable = [
        'first_name','last_name','gender','dob','reg_num','image','faculty','department','admin_id','status'
    ];
}
