<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'tipo', 'name','id'];

    public function sends()
    {
        //return $this->hasMany(SendEmail::class);
        return $this->hasMany(SendEmail::class, 'campaing_id', 'id');
    }

}
