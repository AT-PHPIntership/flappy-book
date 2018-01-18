<?php
return [
    'login' => [
        'datetime_format' => 'Y-m-d h:i:s',
        'msg_success' => 'successfully',
    ],
    'books' => [
        'limit_rows' => 10,
        'name_prefix' => date("Ymd"),
        'folder_store' => 'images/books',
        'default_image' => 'images/books_image.png',
    ],
    'users' => [
    	'limit_rows' => 10
    ],
];
