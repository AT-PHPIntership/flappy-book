<?php

namespace App\Transformers;

use App\Model\Book;
use League\Fractal\TransformerAbstract;
use League\Fractal\Serializer\ArraySerializer;
use League\Fractal\Serializer\DataArraySerializer;
use Illuminate\Support\Facades\App;

class RatingOfBookTransformer extends TransformerAbstract
{
    /**
     * Transform
     *
     * @param Book $book book
     *
     * @return Array
     */
    public function transform(Book $book)
    {
        return [
            'id' => (int) $book->id,
            'rating' => (int) $book->rating,
        ];
    }
}
