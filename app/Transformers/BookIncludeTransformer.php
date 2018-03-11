<?php

namespace App\Transformers;

use App\Model\Book;
use League\Fractal\TransformerAbstract;

class BookIncludeTransformer extends TransformerAbstract
{
    /**
     * Transform
     *
     * @param Book $book Book
     *
     * @return array
     */
    public function transform(Book $book)
    {
        return [
            'id' => (int) $book->id,
            'title' => (string) $book->title,
            'picture' => (string) $book->picture,
            'total_rating' => (int) $book->total_rating,
            'rating' => $book->rating
        ];
    }
}
