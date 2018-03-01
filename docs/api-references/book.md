## Books API

### `GET` Book
```
/api/books/{id}
```
Get a detail book
#### Parameter
| Field | Type | Description |
|-------|------|-------------|
| id | Number | Id of book |


#### Response - Success
| Field | Type | Description |
|-------|------|-------------|
| meta | Object | object meta |
| status | String | Status result |
| code | Number | HTTP status codes |
| data | Object | Object book |
| id | Number | Id of book |
| title | String | Title of book |
| category_id | Number | Book's category id |
| description | String | Description of book |
| language | String | Language of book |
| rating | Number | Average review of a book |
| total_rating | Number | The total number of reviews of a book |
| picture | String | Url for image of the book |
| author | String | Author of book |
| price | Number | Price of book |
| unit | String | Unit of price |
| year | Number | Year of publication |
| page_number | Number | Pages number of book |
| Status | Number | Status available of book |
| user_id | Number | Id of donator |
| donator | String | Name of donator |
| category | Object | Object category |
| id | Number | Id of category |
| title | String | Title of category |


```json
{
    "meta": {
        "status": "successfuly",
        "code": 200
    },
    "data": {
        "id": 17,
        "title": "Code dạo ký sự",
        "category_id": 6,
        "description": "<p>CDKS</p>",
        "language": "VI",
        "rating": 0.0,
        "total_rating": 0,
        "picture": "http://book.aug/images/books/20180209.jpeg",
        "author": "Phạm Huy Hoàng",
        "price": 150000.00,
        "unit": "VND",
        "year": 2016,
        "page_number": 320,
        "status": 0,
        "user_id": 11,
        "donator": "Minh Dao T.",
        "category": {
            "id": 6,
            "title": "Talon Lebsack"
        }
    }
}
```
#### Response - Fail
| Field | Type | Description |
|-------|------|-------------|
| meta | Object | object meta |
| status | String | Status result |
| code | Number | HTTP status codes |
| error | Object | object error |
| message | String |error message |
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

### `GET` List book
```
/api/books
```
Get list books with paginate


#### Response - Success
| Field | Type | Description |
|-------|------|-------------|
| meta | Object | object meta |
| status | String | Status result |
| code | Number | HTTP status codes |
| data | Object | Object book |
| id | Number | Id of book |
| title | String | Title of book |
| total_rating | Number | The total number of reviews of a book |
| picture | String | Url for image of the book |
| rating | Number | The number of reviews of a book |

```json
"meta": {
            "status": "successfully",
            "code": 200
         }
"data": [
        {
            "id": 32,
            "title": "Miss Yolanda Moore I",
            "picture": "http://flappybook.tech/images/books/639802f65e69608edf2700e979022e1d.png",
            "total_rating": 15,
            "rating": 4
        },
        {
            "id": 31,
            "title": "Mr. Conrad Ryan",
            "picture": "http://flappybook.tech/images/books/639802f65e69608edf2700e979022e1d.png",
            "total_rating": 2,
            "rating": 3
        },
        ],
"pagination": {
                "total": 32,
                "per_page": 20,
                "count": 20,
                "current_page": 1,
                "total_pages": 2,
                "links": {
                    "prev": null,
                    "next": "http://flappybook.tech/api/books?page=2"
              }
}
```    
#### Response - Fail
| Field | Type | Description |
|-------|------|-------------|
| meta | Object | object meta |
| status | String | Status result |
| code | Number | HTTP status codes |
| error | Object | object error |
| message | String |error message |
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

### `GET` Top 10 Books Review
```
/api/books/top-review
```
Get top 10 books review
#### Response - Success
| Field | Type | Description |
|-------|------|-------------|
| meta | Object | Object meta |
| status | String | Status result |
| code | Number | HTTP status codes |
| data | Array | Array of list top books review |
| id | Number | Id of book |
| title | String | Title of book |
| rating | Number | Average review of a book |
| total_rating | Number | The total number of reviews of a book |
| picture | String | Url for image of the book |


```json
{
    "meta": {
        "status": "Successfuly",
        "code": 200
    },
    "data": [
        {
            "id": 1,
            "title": "Book 1",
            "rating": 4.0,
            "total_rating": 5,
            "picture": "http://book.aug/images/books/20180201.jpeg",
        },
        {
            "id": 2,
            "title": "Book 2",
            "rating": 4.0,
            "total_rating": 5,
            "picture": "http://book.aug/images/books/20180202.jpeg",
        },
        {
            "id": 3,
            "title": "Book 3",
            "rating": 4.0,
            "total_rating": 3,
            "picture": "http://book.aug/images/books/20180209.jpeg",
        },
        {
            "id": 4,
            "title": "Book 4",
            "rating": 4.5,
            "total_rating": 5,
            "picture": "http://book.aug/images/books/20180206.jpeg",
        },
        {
            "id": 5,
            "title": "Book 5",
            "rating": 3.0,
            "total_rating": 2,
            "picture": "http://book.aug/images/books/20180207.jpeg",
        },
        {
            "id": 6,
            "title": "Book 6",
            "rating": 4.0,
            "total_rating": 5,
            "picture": "http://book.aug/images/books/20180208.jpeg",
        },
        {
            "id": 7,
            "title": "Book 7",
            "rating": 4.0,
            "total_rating": 5,
            "picture": "http://book.aug/images/books/20180209.jpeg",
        },
        {
            "id": 8,
            "title": "Book 8",
            "rating": 4.0,
            "total_rating": 5,
            "picture": "http://book.aug/images/books/201802023.jpeg",
        },
        {
            "id": 9,
            "title": "Book 9",
            "rating": 4.0,
            "total_rating": 5,
            "picture": "http://book.aug/images/books/10180209.jpeg",
        },
        {
            "id": 10,
            "title": "Book 10",
            "rating": 4.5,
            "total_rating": 3,
            "picture": "http://book.aug/images/books/20480209.jpeg",
        },
    ]
}
```

### `GET` Search books with keyword.
```
/api/books?search={key}
```
    Get list book with correct keyword.

#### Response - Success
| Field | Type | Array |
|-------|------|-------------|
| meta | Object | object meta |
| status | String | Status result |
| code | Number | HTTP status codes |
| data | Array | Array book |
| id | Number | Id of book |
| title | String | Title of book |
| total_rating | Number | The total number of reviews of a book |
| picture | String | Url for image of the book |
| author | String | The author of book |
| rating | Number | The number of reviews of a book |

```json
{
    "meta": {
        "status": "successfully",
        "code": 200
    }
    "data": [
        {
            "id": 1,
            "title": "Miss Yolanda Moore I",
            "author": "Mueller",
            "picture": "http://flappybook.tech/images/books/639802f65e69608edf2700e979022e1d.png",
            "total_rating": 15,
            "rating": 4
        },
        {
            "id": 2,
            "title": "Mueller Parker",
            "author": "Edison",
            "picture": "http://flappybook.tech/images/books/639802f65e69608edf2700e979022e1d.png",
            "total_rating": 2,
            "rating": 3
        },
    ],
    "pagination": {
        "total": 1,
        "per_page": 20,
        "current_page": 1,
        "total_pages": 1,
        "links": {
            "prev": null,
            "next": null
        }
    }
}
```
#### Response - Fail
| Field | Type | Description |
|-------|------|-------------|
| meta | Object | object meta |
| status | String | Status result |
| code | Number | HTTP status codes |
| error | Object | object error |
| message | String |error message |
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
