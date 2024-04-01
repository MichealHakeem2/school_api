<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class student_Registr extends Model
{
    use HasApiTokens, Notifiable, HasFactory;
    protected $table="student";
    protected $fillable = ['first_name', 'middle_name', 'last_name', 'birth_date', 'address', 'phone_number', 'email', 'gender', 'class', 'parent_name'];
}
