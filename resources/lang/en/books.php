<?php
return [
    'edit_book' => 'Edit Book',
    'list_books' => 'List Books',
    'home' => ' Home',
    'books' => 'Books',
    'list' => 'List',
    'no' => 'No',
    'title' => 'Title',
    'price' => 'Price',
    'unit' => 'Unit',
    'vnd' => 'VND',
    'description' => 'Description',
    'from_person' => 'From Person',
    'category' => 'Category',
    'place_some_text_here' => 'Place some text here',
    'author' => 'Author',
    'rating' => 'Rating',
    'total_borrowed' => 'Total Borrowed',
    'year' => 'Year',
    'options' => 'Options',
    'picture' => 'Picture',
    'update' => 'Update',
    'create_book' => 'Create Book',
    'create_success' => 'Create Success',
    'create_failure' => 'Create Failure',
    'category' => 'Category',
    'create' => 'Create',
    'back' => 'Back',
    'add_book' => 'Add Book',
    'search' => 'Search',
    'all' => 'All',
    'delete' => 'Delete',
    'close' => 'Close',
    'confirm_deletion' => 'Confirm deletion!',
    'are_you_sure_you_want_to_delete' => 'Are you sure you want to delete?',
    'books_edit_success' => 'Edit book success!',
    'books_edit_failed' => 'Edit book failed!',
    'delete_book_success' => 'Delete Book Success!',
    'delete_book_fail' => 'Delete Book Fail!',
    'listunit' => [
        \App\Model\Book::TYPE_VND => 'VND',
        \App\Model\Book::TYPE_DOLAR => '$',
        \App\Model\Book::TYPE_EURO => '€',
        \App\Model\Book::TYPE_YEN => '¥'
    ],
    'list_search' =>[
        \App\Model\Book::TYPE_ALL => 'Title or Author',
        \App\Model\Book::TYPE_TITLE => 'Title',
        \App\Model\Book::TYPE_AUTHOR => 'Author'
    ],
];
