<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class attendance extends Model
{
    use Notifiable, HasFactory;
    protected $table="attendance";
    protected $fillable = ['student_id', 'date', 'status'];
}
