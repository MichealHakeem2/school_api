<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class assignment extends Model
{
    use Notifiable, HasFactory;
    protected $table="assignment";
    protected $fillable = ['course_id', 'due_date', 'status'];
}
