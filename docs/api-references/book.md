## Books API

### `GET` Book
```
/api/books/{id}
```
Get a detail book with category
#### Request Headers
| Key | Value |
|---|---|
|Accept|application\json

#### Response - Success
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
        "rating": "0.0",
        "total_rating": 0,
        "picture": "http://book.aug/images/books/20180209.jpeg",
        "author": "Phạm Huy Hoàng",
        "price": "150000.00",
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
