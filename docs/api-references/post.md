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
| status | Number | Status of post |
| user_id | Number | Id of user create post |
| created_at | String | Create book time |
| updated_at | String | Update book time |
| like | Object | Object like |
| likes | Number | Number of likes |
| user | Object | Object user |
| id | Number | Id of user |
| name | String | Name of user |
| team | String | Team of user |
| avatar_url | String | Url of user's avatar |
| is_admin | Number | Role of user |
| rating | Object | Object rating |
| id | Number | Id of rating |
| book_id | Number | Id of book |
| post_id | Number | Id of post |
| rating | Number | Rating of book |
| pagination | Object | Object pagination |
| total | Number | Total posts |
| count | Number | Total posts in current page |
| per_page | Number | Posts per page |
| current_page | Number | Number of current page |
| total_pages | Number | Total pages |
| links | Object | Object Links |
| prev | String | Link of previous page |
| next | String | Link of next page |

```json
{
    "meta": {
        "status": "Successfully",
        "code": 200
    },
    "data": [
        {
            "id": 83,
            "content": "Et excepturi ipsa iusto repellat molestiae. Aut esse voluptatum omnis dignissimos pariatur et.",
            "status": 2,
            "user_id": 10,
            "created_at": "2018-03-09 08:41:27",
            "updated_at": "2018-03-09 08:41:27",
            "like": {
                "likes": 0
            },
            "user": {
                "id": 10,
                "name": "Mrs. Luz Gorczany",
                "team": "ANDROID",
                "avatar_url": "/tmp/1f02d6771e184b83b106fb678405d06b.jpg",
                "is_admin": 0
            },
            "rating": {
                "id": 36,
                "book_id": 1,
                "post_id": 83,
                "rating": 1
            }
        },
        {
            "id": 84,
            "content": "Et excepturi ipsa iusto repellat molestiae. Aut esse voluptatum omnis dignissimos pariatur et.",
            "status": 2,
            "user_id": 10,
            "created_at": "2018-03-09 08:41:36",
            "updated_at": "2018-03-09 08:41:36",
            "like": {
                "likes": 0
            },
            "user": {
                "id": 10,
                "name": "Mrs. Luz Gorczany",
                "team": "ANDROID",
                "avatar_url": "/tmp/1f02d6771e184b83b106fb678405d06b.jpg",
                "is_admin": 0
            },
            "rating": {
                "id": 37,
                "book_id": 1,
                "post_id": 84,
                "rating": 1
            }
        }
    ],
    "pagination": {
        "total": 32,
        "count": 2,
        "per_page": 10,
        "current_page": 4,
        "total_pages": 4,
        "links": {
            "previous": "http://flappybook.tech/api/books/1/reviews?page=3"
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
|-------|------|-------------|
| meta | Object | Object meta |
| status | String | Status result |
| code | Number | HTTP status codes |
| data | Array | Array list posts |
| id | Number | Id of post |
| content | String | Content of post |
| status | Number | Status of post |
| user_id | Number | Id of user create post |
| created_at | String | Create book time |
| updated_at | String | Update book time |
| like | Object | Object like |
| likes | Number | Number of likes |
| book | Object | Object book |
| id | Number | Id of book |
| title | String | Name of book |
| picture | String | Picture of book |
| rating | Object | Object rating |
| id | Number | Id of rating |
| book_id | Number | Id of book |
| post_id | Number | Id of post |
| rating | Number | Rating of book |
| pagination | Object | Object pagination |
| total | Number | Total posts |
| count | Number | Total posts in current page |
| per_page | Number | Posts per page |
| current_page | Number | Number of current page |
| total_pages | Number | Total pages |
| links | Object | Object Links |
| prev | String | Link of previous page |
| next | String | Link of next page |

```json
{
    "meta": {
        "status": "Successfully",
        "code": 200
    },
    "data": [
        {
            "id": 84,
            "content": "Et excepturi ipsa iusto repellat molestiae. Aut esse voluptatum omnis dignissimos pariatur et.",
            "status": 1,
            "user_id": 10,
            "created_at": "2018-03-09 08:41:36",
            "updated_at": "2018-03-09 08:41:36",
            "like": {
                "likes": 5
            },
            "book": {
                "id": 10,
                "title": "ANDROID",
                "picture": "http://book.aug/images/books/20180226-j9WeHiBsR1xypnStXGJ54ttvulu7RK0USbDBtEVM.jpeg",
            },
            "rating": {
                "id": 37,
                "book_id": 1,
                "post_id": 84,
                "rating": 1
            }
        },
        {
            "id": 84,
            "content": "Et excepturi ipsa iusto repellat molestiae. Aut esse voluptatum omnis dignissimos pariatur et.",
            "status": 2,
            "user_id": 10,
            "created_at": "2018-03-09 08:41:36",
            "updated_at": "2018-03-09 08:41:36",
            "like": {
                "likes": 5
            },
            "book": {
                "id": 10,
                "title": "ANDROID",
                "picture": "http://book.aug/images/books/20180226-j9WeHiBsR1xypnStXGJ54ttvulu7RK0USbDBtEVM.jpeg",
            },
            "rating": {
                "id": 37,
                "book_id": 1,
                "post_id": 84,
                "rating": 1
            }
        },
        {
            "id": 86,
            "content": "Et excepturi ipsa iusto repellat molestiae. Aut esse voluptatum omnis dignissimos pariatur et.",
            "status": 2,
            "user_id": 10,
            "created_at": "2018-03-09 08:41:36",
            "updated_at": "2018-03-09 08:41:36",
            "like": {
                "likes": 5
            },
            "book": {
                "id": 18,
                "title": "IOS",
                "picture": "http://book.aug/images/books/20180226-j9WeHiBsR1xypnStXGJ54ttvulu7RK0USbDBtEVM.jpeg",
            },
            "rating": {
                "id": 37,
                "book_id": 18,
                "post_id": 86,
                "rating": 3
            }
        }
    ],
    "pagination": {
        "total": 23,
        "count": 3,
        "per_page": 20,
        "curent_page": 2,
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
| team | String | Team of user |
| avatar_url | String | User's picture |
| is_admin | Number | Role of user |
| book_id | Number | Id of book |
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
            "id": 84,
            "content": "Et excepturi ipsa iusto repellat molestiae. Aut esse voluptatum omnis dignissimos pariatur et.",
            "status": 0,
            "user_id": 10,
            "created_at": "2018-03-09 08:41:36",
            "updated_at": "2018-03-09 08:41:36",
            "like": {
                "likes": 5
            },
            "book": {
                "id": 10,
                "title": "ANDROID",
                "picture": "http://book.aug/images/books/20180226-j9WeHiBsR1xypnStXGJ54ttvulu7RK0USbDBtEVM.jpeg",
            },
            "rating": null
        },
        {
            "id": 86,
            "content": "Et excepturi ipsa iusto repellat molestiae. Aut esse voluptatum omnis dignissimos pariatur et.",
            "status": 0,
            "user_id": 10,
            "created_at": "2018-03-09 08:41:36",
            "updated_at": "2018-03-09 08:41:36",
            "like": {
                "likes": 5
            },
            "book": {
                "id": 10,
                "title": "ANDROID",
                "picture": "http://book.aug/images/books/20180226-j9WeHiBsR1xypnStXGJ54ttvulu7RK0USbDBtEVM.jpeg",
            },
            "rating": null
        }
    ],
    "pagination": {
        "total": 2,
        "count": 2,
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
            "id": 84,
            "content": "Et excepturi ipsa iusto repellat molestiae. Aut esse voluptatum omnis dignissimos pariatur et.",
            "status": 1,
            "user_id": 10,
            "created_at": "2018-03-09 08:41:36",
            "updated_at": "2018-03-09 08:41:36",
            "like": {
                "likes": 5
            },
            "book": {
                "id": 10,
                "title": "ANDROID",
                "picture": "http://book.aug/images/books/20180226-j9WeHiBsR1xypnStXGJ54ttvulu7RK0USbDBtEVM.jpeg",
            },
            "rating": null
        },
        {
            "id": 84,
            "content": "Et excepturi ipsa iusto repellat molestiae. Aut esse voluptatum omnis dignissimos pariatur et.",
            "status": 1,
            "user_id": 10,
            "created_at": "2018-03-09 08:41:36",
            "updated_at": "2018-03-09 08:41:36",
            "like": {
                "likes": 5
            },
            "book": {
                "id": 10,
                "title": "ANDROID",
                "picture": "http://book.aug/images/books/20180226-j9WeHiBsR1xypnStXGJ54ttvulu7RK0USbDBtEVM.jpeg",
            },
            "rating": null
        }
    ],
    "pagination": {
        "total": 2,
        "count": 2,
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
            "id": 84,
            "content": "Et excepturi ipsa iusto repellat molestiae. Aut esse voluptatum omnis dignissimos pariatur et.",
            "status": 2,
            "user_id": 10,
            "created_at": "2018-03-09 08:41:36",
            "updated_at": "2018-03-09 08:41:36",
            "like": {
                "likes": 5
            },
            "book": {
                "id": 10,
                "title": "ANDROID",
                "picture": "http://book.aug/images/books/20180226-j9WeHiBsR1xypnStXGJ54ttvulu7RK0USbDBtEVM.jpeg",
            },
            "rating": {
                "id": 37,
                "book_id": 10,
                "post_id": 84,
                "rating": 1
            }
        },
        {
            "id": 85,
            "content": "Et excepturi ipsa iusto repellat molestiae. Aut esse voluptatum omnis dignissimos pariatur et.",
            "status": 2,
            "user_id": 10,
            "created_at": "2018-03-09 08:41:36",
            "updated_at": "2018-03-09 08:41:36",
            "like": {
                "likes": 5
            },
            "book": {
                "id": 11,
                "title": "ANDROID",
                "picture": "http://book.aug/images/books/20180226-j9WeHiBsR1xypnStXGJ54ttvulu7RK0USbDBtEVM.jpeg",
            },
            "rating": {
                "id": 37,
                "book_id": 11,
                "post_id": 85,
                "rating": 1
            }
        }
    ],
    "pagination": {
        "total": 2,
        "count": 2,
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
| rating | Object | Object rating |

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
        "user_id": 1,
        "created_at": "2018-03-06 08:53:31",
        "updated_at": "2018-03-06 08:53:31",
        "like": {
            "likes": 0
        },
        "user": {
            "id": 1,
            "name": "Cao Nguyen V.",
            "team": "PHP",
            "avatar_url": "http://172.16.110.158/public/uploads/images/image/file/248/b041cdd0181519816611.png",
            "is_admin": 0,
        },
        "rating": {
            "id": 51,
            "book_id": 1,
            "post_id":145,
            "rating": 3
        }
    }
}
```
