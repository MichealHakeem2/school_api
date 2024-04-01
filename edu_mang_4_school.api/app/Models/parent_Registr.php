<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class parent_Registr extends Model
{
    use HasApiTokens, Notifiable, HasFactory;
    protected $table="parent";
    protected $fillable = ['first_name', 'last_name', 'phone_number', 'email', 'address', 'job'];
}
