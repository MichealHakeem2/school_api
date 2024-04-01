<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory;
    protected $table="admin";
    protected $fillable =['name','email','password','image'];
    protected $hidden = ['password', 'remember_token',];
}
