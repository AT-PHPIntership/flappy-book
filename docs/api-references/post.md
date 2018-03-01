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
| content | String | Content of post |
| name | String | Name of user |
| team | String | Team of user |
| avatar_url | String | Url of user's avatar |
| rating | Number | Rating for book |
| likes | Number | likes of post |
| created_at | String | Create book time |
| updated_at | String | Update book time |
| deleted_at | String | Delete book time |
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
            "content": "Molestiae voluptas cum ullam accusantium fuga magnam.",
            "name": "Greta Lehner",
            "team": "SA",
            "avatar_url": "http://172.16.110.17/images/user/avatar/366/64weew314e61ccc.png",
            "rating": "3.0",
            "likes": 1,
            "created_at": "2018-02-08 16:34:10",
            "updated_at": "2018-02-08 16:34:10",
            "deleted_at": null
        },
        {
            "id": 15,
            "content": "Vel natus quo explicabo cupiditate autem dolor et aliquid.",
            "name": "Mr. Morris Glover V",
            "team": "PHP",
            "avatar_url": "http://172.16.110.17/images/user/avatar/366/64314e61ccc.png",
            "rating": "2.0",
            "likes": 0,
            "created_at": "2018-02-08 16:34:10",
            "updated_at": "2018-02-08 16:34:10",
            "deleted_at": null
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

##### Request header 
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

```json
{
    "meta": {
        "status": "Successfully",
        "code": 201
    },
    "data": [
        {
            "id": 25,
            "user_id": 11,
            "content": "nguyen vancao",
            "status": 2,
            "name": "Cao Nguyen V.",
            "team": "PHP",
            "avatar_url": "http://172.16.110.17/images/user/avatar/366/64314e61c9.png",
            "is_admin": 0,
            "picture": "http://book.aug/images/books/20180209.jpeg",
            "title": "Prof. Julio Bechtelar III",
            "book_id": 3,
            "rating": "3.0",
            "likes": 0,
            "created_at": "2018-03-01 09:27:38",
            "updated_at": "2018-03-01 09:27:38"
        }
    ]
}
```
