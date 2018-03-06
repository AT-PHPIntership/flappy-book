## Post Api
### `GET` Reviews for Book
```
/api/books/{id}/reviews
```
Get Posts with status review for Book

#### Parameters
| Key | Type | Description |
|---|---|---|
| id | Number | Id of book |

#### Response - Success
| Field | Type | Description |
|-------|------|-------------|
| meta | Object | Object meta |
| status | String | Status result |
| code | Number | HTTP status codes |
| data | Array | Array list posts |
| id | Number | Id of post |
| user_id | Number | Id of user create post |
| content | String | Content of post |
| status | Number | Status of post |
| name | String | Name of user |
| team | String | Team of user |
| avatar_url | String | Url of user's avatar |
| is_admin | Number | Role of user |
| picture | String | Picture of book |
| title | String | Title of book |
| book_id | Number | Id for book |
| rating | Number | Rating for book |
| likes | Number | likes of post |
| created_at | String | Create book time |
| updated_at | String | Update book time |
| pagination | Object | Object pagination |
| total | Number | Total posts |
| per_page | Number | Posts per page |
| current_page | Number | Number of current page |
| total_pages | Number | Total pages |
| links | Object | Object Links |
| prev | String | Link of previous page |
| next | String | Link of next page |

```json
{
    "meta": {
        "status": "successfuly",
        "code": 200,
    },
    "data": [
        {
            "id": 1,
            "user_id": 10,
            "content": "Molestiae voluptas cum ullam accusantium fuga magnam.",
            "status": 2,
            "name": "Greta Lehner",
            "team": "SA",
            "avatar_url": "http://172.16.110.17/images/user/avatar/366/64weew314e61ccc.png",
            "is_admin": 0,
            "picture": "http://book.aug/images/books/20180209.jpeg",
            "title": "Molestiae voluptas",
            "book_id": 3,
            "rating": "3.0",
            "likes": 1,
            "created_at": "2018-02-08 16:34:10",
            "updated_at": "2018-02-08 16:34:10",
        },
        {
            "id": 15,
            "user_id": 2,
            "content": "Vel natus quo explicabo cupiditate autem dolor et aliquid.",
            "status": 2,
            "name": "Mr. Morris Glover V",
            "team": "PHP",
            "avatar_url": "http://172.16.110.17/images/user/avatar/366/3122323e61drf.png",
            "is_admin": 0,
            "picture": "http://book.aug/images/books/er345ss34.jpeg",
            "title": "Molestiae voluptas",
            "book_id": 3,
            "rating": "3.0",
            "likes": 1,
            "created_at": "2018-02-08 16:34:10",
            "updated_at": "2018-02-08 16:34:10",
        }
    ],
    "pagination": {
        "total": 12,
        "per_page": 10,
        "current_page": 2,
        "total_pages": 2,
        "links": {
            "prev": "http://flappybook.tech/api/books/14/reviews?page=1",
            "next": null
        }
    }
}
```

#### Response - Fail
| Field | Type | Description |
|-------|------|-------------|
| meta | Object | Object meta |
| status | String | Status result |
| code | Number | HTTP status codes |
| error | Object | Object error |
| message | String | Error message |

```json
{
    "meta": {
        "status": "failed",
        "code": 404
    },
    "error": {
        "message": "Page not found!"
    }
}
```
### Get List Posts By User
#### Get list posts by user have filter is all

```
/api/users/{id}/posts

```
Get list all posts by user with paginate
##### Request header 
| Key | Value |
|---|---|
|Accept|application\json|
|Authorization|{token_type} {access_token}
##### Parameters
| Key | Value | Required | Description |
|---|---|---|---|
| id | Interger | required | Id of user |

##### Response - Success
| Field | Type | Description |
|---|---|---|
| data | Object | Object posts |
| id | Number | Id of post |
| content | String | Content of post |
| status | Number | Post type |
| user_id | Number | Id of user |
| name | String | Name of user |
| picture | String | Book's picture |
| title | String | Book's name |
| rating | Number | Rating for post |
| like | Number | Likes of posts |
| created_at | String | Create date of the post |
| updated_at | String | Update date of the post |
| meta | Object | Object meta |
| total | Number | Total item |
| count | Number | Total item on current page |
| per_page | Number | Total item on per page |
| current_page | Number | Current page |
| total_page | Number | Total page |
| link | String | Page url |
| status | String | Status result |
| code | Number | HTTP status code |

```json
{
    "meta": {
        "status": "Successfully",
        "code": 200
    },
    "data": [
        {
            "id": 1,
            "content": "Et excepturi ipsa iusto repellat molestiae. Aut esse voluptatum omnis dignissimos pariatur et.",
            "status": 1,
            "user_id": 1,
            "name": "Tram Pham T.M.",
            "picture": "http://book.aug/images/books/20180226-j9WeHiBsR1xypnStXGJ54ttvulu7RK0USbDBtEVM.jpeg",
            "title": "HTML5 & CSS3",
            "rating": 3.0,
            "like": 1,
            "created_at": "2018-02-08 07:35:34",
            "updated_at": "2018-02-10 08:35:30",
        },
        {
            "id": 3,
            "content": "Et excepturi ipsa iusto repellat molestiae. Aut esse voluptatum omnis dignissimos pariatur et.",
            "status": 0,
            "user_id": 1,
            "picture": "http://book.aug/images/books/20180226-j9WeHiBsR1xypnStXGJ54ttvulu7RK0USbDBtEVM.jpeg",
            "title": "HTML5",
            "rating": 4.0,
            "like": 1,
            "created_at": "2018-01-08 07:35:34",
            "updated_at": "2018-02-10 08:35:30",
        },
        {
            "id": 8,
            "content": "Et excepturi ipsa iusto repellat molestiae. Aut esse voluptatum omnis dignissimos pariatur et.",
            "status": 2,
            "user_id": 1,
            "name": "Tram Pham T.M.",
            "picture": "http://book.aug/images/books/20180226-j9WeHiBsR1xypnStXGJ54ttvulu7RK0USbDBtEVM.jpeg",
            "title": "CSS3",
            "rating": 5.0,
            "like": 1,
            "created_at": "2018-02-20 07:35:34",
            "updated_at": "2018-02-22 08:35:30",
        }
    ],
    "pagination": {
        "total": 25,
        "count": 20,
        "per_page": 20,
        "curent_page": 1,
        "total_page": 2,
        "link": {
            "prev": null,
            "next": "http://flappybook.tech/users/1/posts?page=2",
        }
    }
}
```
#### Get list posts by user have filter is status

```
/api/users/{id}/posts?status=0

```
Get list all posts by user with paginate
##### Request header 
| Key | Value |
|---|---|
|Accept|application\json|
|Authorization|{token_type} {access_token}
##### Parameters
| Key | Value | Required | Description |
|---|---|---|---|
| id | Interger | required | Id of user |
| status | Interger | required | Post type(status,find book,review) |

##### Response - Success
| Field | Type | Description |
|---|---|---|
| data | Object | Object posts |
| id | Number | Id of post |
| content | String | Content of post |
| status | Number | Post type |
| user_id | Number | Id of user |
| name | String | Name of user |
| picture | String | Book's picture |
| title | String | Book's name |
| rating | Number | Rating for post |
| like | Number | Likes of posts |
| created_at | String | Create date of the post |
| updated_at | String | Update date of the post |
| meta | Object | Object meta |
| total | Number | Total item |
| count | Number | Total item on current page |
| per_page | Number | Total item on per page |
| current_page | Number | Current page |
| total_page | Number | Total page |
| link | String | Page url |
| status | String | Status result |
| code | Number | HTTP status code |

```json
{
    "meta": {
        "status": "Successfully",
        "code": 200
    },
    "data": [
        {
            "id": 3,
            "content": "Et excepturi ipsa iusto repellat molestiae. Aut esse voluptatum omnis dignissimos pariatur et.",
            "status": 0,
            "user_id": 1,
            "name": "Tram Pham T.M.",
            "picture": null,
            "title": null,
            "rating": null,
            "like": 1,
            "created_at": "2018-02-08 07:35:34",
            "updated_at": "2018-02-10 08:35:30",
        },
        {
            "id": 10,
            "content": "Et excepturi ipsa iusto repellat molestiae. Aut esse voluptatum omnis dignissimos pariatur et.",
            "status": 0,
            "user_id": 1,
            "name": "Tram Pham T.M.",
            "picture": null,
            "title": null,
            "rating": null,
            "like": 2,
            "created_at": "2018-01-08 07:35:34",
            "updated_at": "2018-02-10 08:35:30",
        },
    ],
    "pagination": {
        "total": 22,
        "count": 20,
        "per_page": 20,
        "curent_page": 1,
        "total_page": 1,
        "link": {
            "prev": null,
            "next": "http://flappybook.tech/users/1/posts?status=0&page=2",
        }
    }
}
```
#### Get list posts by user have filter is find book

```
/api/users/{id}/posts?status=1

```
Get list all posts by user with paginate

```json
{
    "meta": {
        "status": "Successfully",
        "code": 200
    },
    "data": [
        {
            "id": 2,
            "content": "Et excepturi ipsa iusto repellat molestiae. Aut esse voluptatum omnis dignissimos pariatur et.",
            "status": 1,
            "user_id": 1,
            "name": "Tram Pham T.M.",
            "picture": null,
            "title": null,
            "rating": null,
            "like": 1,
            "created_at": "2018-02-08 07:35:34",
            "updated_at": "2018-02-10 08:35:30",
        },
        {
            "id": 4,
            "content": "Et excepturi ipsa iusto repellat molestiae. Aut esse voluptatum omnis dignissimos pariatur et.",
            "status": 1,
            "user_id": 1,
            "name": "Tram Pham T.M.",
            "picture": null,
            "title": null,
            "rating": null,
            "like": 1,
            "created_at": "2018-01-08 07:35:34",
            "updated_at": "2018-02-10 08:35:30",
        },
    ],
    "pagination": {
        "total": 5,
        "count": 5,
        "per_page": 20,
        "curent_page": 1,
        "total_page": 1,
        "link": {
            "prev": null,
            "next": null,
        }
    }
}
```
#### Get list posts by user have filter is review

```
/api/users/{id}/posts?status=2

```
Get list all posts by user with paginate


```json
{
    "meta": {
        "status": "Successfully",
        "code": 200
    },
    "data": [
        {
            "id": 5,
            "content": "Et excepturi ipsa iusto repellat molestiae. Aut esse voluptatum omnis dignissimos pariatur et.",
            "status": 2,
            "user_id": 1,
            "name": "Tram Pham T.M.",
            "picture": "http://book.aug/images/books/20180226-j9WeHiBsR1xypnStXGJ54ttvulu7RK0USbDBtEVM.jpeg",
            "title": "HTML",
            "rating": 4.0,
            "like": 2,
            "created_at": "2018-02-08 07:35:34",
            "updated_at": "2018-02-10 08:35:30",
        },
        {
            "id": 9,
            "content": "Et excepturi ipsa iusto repellat molestiae. Aut esse voluptatum omnis dignissimos pariatur et.",
            "status": 2,
            "user_id": 1,
            "name": "Tram Pham T.M.",
            "picture": "http://book.aug/images/books/20180226-j9WeHiBsR1xypnStXGJ54ttvulu7RK0USbDBtEVM.jpeg",
            "title": "CSS3",
            "rating": 5.0,
            "like": 2,
            "created_at": "2018-01-08 07:35:34",
            "updated_at": "2018-02-10 08:35:30",
        },
    ],
    "pagination": {
        "count": 12,
        "per_page": 20,
        "curent_page": 1,
        "total_page": 1,
        "link": {
            "prev": null,
            "next": null,
        }
    }
}
```
##### Response - Fail
| Field | Type | Description |
|---|---|---|
| meta | Object | Object meta |
| status | String | Status result |
| code | Number | HTTP status code |
| error | Object | Object error |
| message | String | Error message |

```json
{
    "meta": {
        "status": "Failed",
        "code": 404,
    },
    "error": {
        "message": "Data not found!",
    }
}
```

### `POST` Create new Post
```
/api/posts
```
Create new post

#### Request header
| Key | Value |
|---|---|
|Accept|application\json|
|Authorization|{token_type} {access_token}

#### Parameters
| Key | Value | Required | Description |
|---|---|---|---|
| status | Number | required | Post type (status,find book,review) |
| content | String | required | Content of post |
| book_id | Number | optional | Id book review (required when status is review) |
| rating | Number | optional | Rating for book (required when status is review) |
| include | Array | optional | Table include |

#### Response - Success
| Field | Type | Description |
|-------|------|-------------|
| meta | Object | Object meta |
| status | String | Status result |
| code | Number | HTTP status codes |
| data | Array | Array list posts |
| id | Number | Id of post |
| content | String | Content of post |
| created_at | String | Create book time |
| updated_at | String | Update book time |
| user | Object | Object user |
| book | Object | Object book |
| rating | Object | Object rating |


`url`: `/api/posts`

```json
{
    "meta": {
        "status": "Successfully",
        "code": 201
    },
    "data": {
        "id": 145,
        "content": "nguyen van cao",
        "status": 2,
        "created_at": "2018-03-06 08:53:31",
        "updated_at": "2018-03-06 08:53:31",
    }
}
```

`url`: `api/posts?include=user,book,rating`

```json
{
    "meta": {
        "status": "Successfully",
        "code": 201
    },
    "data": {
        "id": 145,
        "content": "nguyen van cao",
        "status": 2,
        "created_at": "2018-03-06 08:53:31",
        "updated_at": "2018-03-06 08:53:31",
        "user": {
            "id": 1,
            "name": "Cao Nguyen V.",
            "employ_code": "AT0470",
            "email": "cao.nguyen@asiantech.vn",
            "team": "PHP",
            "avatar_url": "http://172.16.110.158/public/uploads/images/image/file/248/b041cdd0181519816611.png",
            "is_admin": 0,
            "created_at": "2018-03-06 02:22:53",
            "updated_at": "2018-03-06 02:37:02"
        },
        "book": {
            "id": 1,
            "title": "Maymie Kuhic",
            "category_id": 10,
            "description": "Quisquam veritatis debitis consequatur corporis doloribus quod non voluptatum. Voluptas eos fugit incidunt voluptatibus. Voluptatem facere labore aut.",
            "language": 0,
            "rating": 2,
            "total_rating": 18,
            "picture": "http://flappybook.tech/images/books//tmp/42a4b9d43447b40733f2befb146829c8.jpg",
            "author": "Mrs. Laura Nolan III",
            "price": 7927,
            "unit": "0",
            "year": 1978,
            "page_number": 358
        },
        "rating": {
            "id": 51,
            "book_id": 1,
            "post_id": 145,
            "rating": 3
        }
    }
}
```
