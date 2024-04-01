<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class exam extends Model
{
    use Notifiable, HasFactory;
    protected $table="exam";
    protected $fillable = ['course_id', 'date', 'max_marks'];
}
