<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buildings extends Model
{
    use HasFactory;
    protected $guarded =[];


    public function projects()
    {
        return $this->belongsTo(Project::class);
    }

    public function apartments()
    {
        return $this->hasMany(Apartments::class, 'building_id', 'id');
    }
}
