<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'mail_host',
        'mail_username',
        'mail_password',
        'aws_access_key_id',
        'aws_secret_access_key',
    ];
}
