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
    	'limit_rows' => 10
    ],
];
