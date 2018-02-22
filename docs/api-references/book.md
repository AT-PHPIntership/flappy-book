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

### `GET` Top books borrow
```
/api/books/borrow/top
```
Get top books borrow

#### Response - Success
| Field | Type | Description |
|-------|------|-------------|
| meta | Object | object meta |
| status | String | Status result |
| code | Number | HTTP status codes |
| data | Object | Object book |
| title | String | Title of book |
| total_rating | Number | The total number of reviews of a book |
| total_borrowed | Number | total_borrowed of book |

```json
{
    "meta": {
        "status": "successfully",
        "code": 200
    },
    "data": [
        {
            "title": "Prof. Aniyah McClure DDS",
            "total_rating": 4,
            "total_borrowed": 4
        },
        {
            "title": "Callie Vandervort DVM",
            "total_rating": 3,
            "total_borrowed": 4
        }
    ],
    "pagination": {
        "total": 2,
        "per_page": 20,
        "count": 10,
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
```
