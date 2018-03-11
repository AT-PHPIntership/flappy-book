<?php

namespace App\Transformers;

use App\Model\Rating;
use League\Fractal\TransformerAbstract;

class RatingTransformer extends TransformerAbstract
{
    /**
     * Transform
     *
     * @param Rating $rating rating
     *
     * @return array
     */
    public function transform(Rating $rating)
    {
        return [
            'id' => (int) $rating->id,
            'book_id' => (int) $rating->book_id,
            'post_id' => (int) $rating->post_id,
            'rating' => (float) $rating->rating,
        ];
    }
}
