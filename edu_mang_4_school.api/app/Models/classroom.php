<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class classroom extends Model
{
    use Notifiable, HasFactory;
    protected $table="classroom";
    protected $fillable = ['grade', 'section', 'teacher_id', 'schedule'];
}
