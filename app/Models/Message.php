<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Chat;

class Message extends Model
{
    public function chats(){
        return $this->hasMany(Chat::class);
    }
}
