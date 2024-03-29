<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ReviewCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'status' => 'success',
            'code' => 200,
            'title' => 'OK',
            'message' => 'Done successfully',
            'method' => request()->method(),
            'url' => request()->fullUrl(),
            'data' => ReviewResource::collection($this->collection)
        ];
    }
}
