<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->message->id,
            'content' => $this->message['content'],
            'type' => $this->type,
            'send_at' => $this->created_at->diffForHumans()
        ];
    }
}
