<?php
return [
    'login' => [
        'datetime_format' => 'Y-m-d h:i:s',
        'msg_success' => 'successfully',
    ],
    'books' => [
        'limit_rows' => 10,
        'image_name_prefix' => date("Ymd"),
        'folder_store_books' => 'images/books/',
        'default_name_image' => 'book_image.png',
    ],
    'users' => [
    	'limit_rows' => 10,
    ],
    'borrows' => [
        'limit_rows' => 10,
        'date_format' => 'd-m-Y',
    ],
    'categories' => [
    	'limit_rows' => 10,
    ],
    'posts' => [
        'limit_rows' => 10,
        'date_format' => 'H:A d-m-Y',
        'size_short_content' => 6,
        'type_review_book' => App\Model\Post::TYPE_REVIEW_BOOK,
        'type_status' => App\Model\Post::TYPE_STATUS,
        'type_find_book' => App\Model\Post::TYPE_FIND_BOOK,
        'three_dots' => '...'
    ],
];
