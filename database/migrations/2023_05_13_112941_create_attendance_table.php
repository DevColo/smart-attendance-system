<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendance', function (Blueprint $table) {
            $table->id();
            $table->unsignedBiginteger('course_id');
            $table->foreign('course_id')->references('id')->on('course');
            $table->string('attendance_date');
            $table->unsignedBiginteger('student_id')->nullable();
            $table->foreign('student_id')->references('id')->on('student');
            $table->string('student_presence_datetime')->nullable();
            $table->unsignedBiginteger('admin_id');
            $table->foreign('admin_id')->references('id')->on('users');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendance');
    }
}
