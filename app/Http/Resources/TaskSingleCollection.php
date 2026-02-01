<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TaskSingleCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        return [
            'data'  => TaskResource::collection($this->collection),
            'links' => [
                'first' => null,
                'last'  => null,
                'prev'  => null,
                'next'  => null,
            ],
            'meta' => [
                'current_page' => 1,
                'from'         => 1,
                'last_page'    => 1,
                'path'         => $request->url(),
                'per_page'     => 1,
                'to'           => 1,
                'total'        => 1,
            ]
        ];
    }
}
