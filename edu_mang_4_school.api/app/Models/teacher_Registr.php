<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;

class teacher_Registr extends Model
{
    use HasApiTokens, Notifiable, HasFactory;
    protected $table="teacher";
    protected $fillable = ['first_name', 'last_name', 'email', 'phone_number', 'subject_taught', 'class_section_assigned'];
}
