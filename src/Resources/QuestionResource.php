<?php

namespace Mindyourteam\Core\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
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
            'id' => $this->id,
            'blueprint_id' => $this->blueprint_id, 
            'user_id' => $this->user_id, 
            'lang' => $this->lang, 
            'type' => $this->type, 
            'printable_type' => $this->printable_type, 
            'min' => $this->min, 
            'max' => $this->max, 
            'epic' => $this->epic, 
            'body' => $this->body, 
            'rationale' => $this->rationale, 
            'planned_at' => $this->planned_at,
        ];
    }
}
