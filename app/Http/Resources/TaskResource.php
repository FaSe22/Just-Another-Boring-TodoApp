<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $title
 * @property mixed $description
 * @property mixed $creator_id
 * @property mixed $assignee_id
 * @property mixed $priority
 * @property mixed $state
 * @property mixed $due
 * @property mixed $histories
 * @property mixed $comments
 */
class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'creator_id' => $this->creator_id,
            'assignee_id' => $this->assignee_id,
            'priority' => $this->priority,
            'state' => $this->state,
            'due_date' => $this->due,
            'history' => $this->histories,
            'comments' => CommentResource::collection($this->whenLoaded('comments')),
        ];
    }
}
