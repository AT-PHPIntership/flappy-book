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
