<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ApiController;
use App\Model\Book;

class BookController extends ApiController
{   
    public function index ()
    {
        $books = Book::get();
        
        return $this->showAll($books);
        
    }
    
    public function show (Book $book)
    {    
        return $this->showOne($book);
    }
}
