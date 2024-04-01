<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class grade extends Model
{
    use Notifiable, HasFactory;
    protected $table="grade";
    protected $fillable = ['student_id', 'course_id', 'marks'];
}
