<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class staff_Registr extends Model
{
    use HasApiTokens, Notifiable, HasFactory;
    protected $table="staff";
    protected $fillable = ['name', 'role_position', 'department', 'phone_number', 'email'];
}
