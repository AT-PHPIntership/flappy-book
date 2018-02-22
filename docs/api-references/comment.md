## Comment Api
### `GET` Comments for Book
```
/api/books/{id}/comments
```
Comments for Book

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
| id | Number | Id of comment |
| content | String | Content of comment |
| name | String | Name of user |
| team | String | Team of user |
| avatar_url | String | Url of user's avatar |
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
        "status": "successfully",
        "code": 200
    },
    "data": [
        {
            "id": 1,
            "content": "Molestiae voluptas cum ullam accusantium fuga magnam.",
            "name": "Greta Lehner",
            "team": "SA",
            "avatar_url": "http://flappybook.tech/tmp/7c5266db2cd916e1af404a688980e4dd.jpg",
            "created_at": "2018-02-08 16:34:10",
            "updated_at": "2018-02-08 16:34:10",
            "deleted_at": null
        },
        {
            "id": 15,
            "content": "Vel natus quo explicabo cupiditate autem dolor et aliquid.",
            "username": "Mr. Morris Glover V",
            "team": "PHP",
            "avatar_url": "http://flappybook.tech/tmp/bb8ab0ad35b2ecfe6e23d5ed0aadbd39.jpg",
            "created_at": "2018-02-08 16:34:18",
            "updated_at": "2018-02-08 16:34:18",
            "deleted_at": null
        }
    ],
    "pagination": {
        "total": 12,
        "per_page": 10,
        "current_page": 2,
        "total_page": 2,
        "link": {
            "prev": "http://flappybook.tech/books/1/comments?page=1",
            "next": null,
        }
    },
}
```
