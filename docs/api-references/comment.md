## Comment Api
### `GET` Comments for Book or Post
```
/api/comments
```
Comments for Book

#### Parameters
| Key | Type | Description |
|---|---|---|
| commentable_type | String | Type of object |
| commentable_id | Number | Id of object |

#### Response - Success
| Field | Type | Description |
|-------|------|-------------|
| meta | Object | Object meta |
| status | String | Status result |
| code | Number | HTTP status codes |
| data | Array | Array list comments |
| id | Number | Id of comment |
| comment | String | Comment |
| commentable_id | Number | Id of object |
| commentable_type | String | Type of object |
| name | String | Name of user |
| team | String | Team of user |
| avatar_url | String | Url of user's avatar |
| is_admin | Number | Role of user |
| parent_id | Number | Parent comment id |
| created_at | String | Create comment time |
| updated_at | String | Update comment time |
| deleted_at | String | Delete comment time |
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
            "comment": "Molestiae voluptas cum ullam accusantium fuga magnam.",
            "commentable_id": 1,
            "commentable_type": "book",
            "name": "Greta Lehner",
            "team": "SA",
            "avatar_url": "http://flappybook.tech/tmp/7c5266db2cd916e1af404a688980e4dd.jpg",
            "is_admin": 0,
            "parent_id": null,
            "created_at": "2018-02-08 16:34:10",
            "updated_at": "2018-02-08 16:34:10",
            "deleted_at": null
        },
        {
            "id": 15,
            "comment": "Vel natus quo explicabo cupiditate autem dolor et aliquid.",
            "commentable_id": 1,
            "commentable_type": "book",
            "name": "Mr. Morris Glover V",
            "team": "PHP",
            "avatar_url": "http://flappybook.tech/tmp/bb8ab0ad35b2ecfe6e23d5ed0aadbd39.jpg",
            "is_admin": 0,
            "parent_id": null,
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
            "prev": "http://flappybook.tech/comments?commentable_type=book&commentable_id=1&page=1",
            "next": null,
        }
    },
}
```
#### Response - Failure validate
| Field | Type | Description |
|-------|------|-------------|
| meta | Object | Object meta |
| status | String | Status result |
| code | Number | HTTP status codes |
| error | Object | Object error |
| message | Object | Object message |
| commentable_type | Array | Error type |
| commentable_id | Array | Error id |

```json
{
    "meta": {
        "status": "Failed",
        "code": 422
    },
    "error": {
        "message": {
            "commentable_type": [
                "The selected commentable type is invalid."
            ],
            "commentable_id": [
                "The commentable id must be an integer."
            ]
        }
    }
}
```

### `POST` Create new Comment
```
/api/comments
```
Create new Comment

#### Parameters
| Key | Type | Description |
|---|---|---|
| commentable_type | String | Type of object |
| commentable_id | Number | Id of object |
| comment | String | Comment |

#### Response - Success
| Field | Type | Description |
|-------|------|-------------|
| meta | Object | Object meta |
| status | String | Status result |
| code | Number | HTTP status codes |
| data | Array | Array list comments |
| id | Number | Id of comment |
| comment | String | Comment |
| commentable_id | Number | Id of object |
| commentable_type | String | Type of object |
| name | String | Name of user |
| team | String | Team of user |
| avatar_url | String | Url of user's avatar |
| is_admin | Number | Role of user |
| parent_id | Number | Parent comment id |
| created_at | String | Create comment time |
| updated_at | String | Update comment time |
| deleted_at | String | Delete comment time |

```json
{
    "meta": {
        "status": "successfully",
        "code": 200
    },
    "data": {
        "id": 20,
        "comment": "Molestiae voluptas cum ullam accusantium fuga magnam.",
        "commentable_id": 1,
        "commentable_type": "book",
        "name": "Greta Lehner",
        "team": "SA",
        "avatar_url": "http://flappybook.tech/tmp/7c5266db2cd916e1af404a688980e4dd.jpg",
        "is_admin": 0,
        "parent_id": null,
        "created_at": "2018-02-08 16:34:10",
        "updated_at": "2018-02-08 16:34:10",
        "deleted_at": null
    }
}
```
#### Response - Failure validate
| Field | Type | Description |
|-------|------|-------------|
| meta | Object | Object meta |
| status | String | Status result |
| code | Number | HTTP status codes |
| error | Object | Object error |
| message | Object | Object message |
| commentable_type | Array | Error type |
| commentable_id | Array | Error id |
| comment | Array | Error comment |

```json
{
    "meta": {
        "status": "Failed",
        "code": 422
    },
    "error": {
        "message": {
            "comment": [
                "The comment field is required."
            ],
        }
    }
}
```
