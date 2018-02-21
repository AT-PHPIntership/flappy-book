## BOOK - API

### `GET` List book
```
/api/books
```
Get list books with paginate

#### Request Headers
| Key | Value |
|---|---|
|Accept|application\json

#### Request Body
| Key | Value |
|---|---|
| content | Content |

#### Response
```json
"data": [
        {
            "id": 32,
            "title": "Miss Yolanda Moore I",
            "picture": "http://flappybook.tech/images/books/639802f65e69608edf2700e979022e1d.png",
            "total_rating": 15
        },
        {
            "id": 31,
            "title": "Mr. Conrad Ryan",
            "picture": "http://flappybook.tech/images/books/639802f65e69608edf2700e979022e1d.png",
            "total_rating": 2
        },
        ],
        "meta": {
        "pagination": {
            "total": 32,
            "count": 10,
            "per_page": 10,
            "current_page": 1,
            "total_pages": 4,
            "links": {
                "prev": null,
                "next": "http://flappybook.tech/api/books?page=2"
            }
        },
        "status": "successfully",
        "code": 200
    }
```    
