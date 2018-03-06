<?php

namespace App\Transformers;

use App\Model\Rating;
use League\Fractal\TransformerAbstract;
use League\Fractal\Serializer\ArraySerializer;
use League\Fractal\Serializer\DataArraySerializer;
use Illuminate\Support\Facades\App;

class RatingTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'book'
    ];

    public function transform(Rating $rating)
    {
        return [
            'id' => (int)$rating->id,
            'book_id' => (int)$rating->book_id,
            'post_id' => (int)$rating->post_id,
            'rating' => (float)$rating->rating,
        ];
    }
}
