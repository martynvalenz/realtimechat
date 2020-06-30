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
            'read_at' => $this->read_at_timing($this),
            'send_at' => $this->created_at->diffForHumans()
        ];
    }

    private function read_at_timing($value){
        $read_at = $value->type == 0 ? $value->read_at : null;

        return $read_at ? $read_at->diffForHumans() : null;
    }
}
