<?php

namespace Acme\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Post extends JsonResource
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
            'user' => $this->user,
            'title' => $this->title,
            'slug' => $this->slug,
            'category' => $this->category,
            'tags' => $this->tags,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'secret' => $this->when(0, 'secret-value'),
            'foo' => $this->foobar,
            'situazione' => $this->impostaSituazione(['asdas']),
        ];
    }
}
