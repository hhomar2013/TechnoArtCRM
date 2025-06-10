<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mySettings extends Model
{
    use HasFactory;
    protected $table = 'my_settings';
    protected $fillable = ['app_name','app_email','app_phone','app_address','app_favicon','app_logo'];
    protected $hidden = ['created_at','updated_at'];


}
