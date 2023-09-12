<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnrollmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enrollment', function (Blueprint $table) {
            $table->id();
            $table->unsignedBiginteger('student_id');
            $table->foreign('student_id')->references('id')->on('student');
            $table->unsignedBiginteger('course_id');
            $table->foreign('course_id')->references('id')->on('course');
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
        Schema::dropIfExists('enrollment');
    }
}
