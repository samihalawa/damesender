<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sendemail extends Model
{
    use HasFactory;
    protected $fillable = ['aws_message_id', 'to_email_address', 'subject', 'message', 'delivered', 'bounced', 'complaint', 'opened'];

}
