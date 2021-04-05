<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SendEmail extends Model
{
    use HasFactory;
    protected $fillable = ['aws_message_id', 'to_email_address','campaing_id', 'subject', 'message', 'delivered', 'bounced', 'complaint', 'opened','unsuscribe'];
    protected $table="send_emails";
   
    public function campaing()
    {
        //return $this->belongsTo(Campaign::class);

        return $this->belongsTo(Campaign::class, 'campaing_id');
    }
}
