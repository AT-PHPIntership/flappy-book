## Post Api
### `GET` Reviews for Book
```
/api/books/{id}/reviews
```
Reviews for Book

#### Request Headers

| Key | Value |
|---|---|
|Accept|application\json
#### Parameters
| Key | Type | Required | Description |
|---|---|---|---|
| book_id | Integer | required | Id of book |
#### Response
```json
{
    "meta": {
        "status": "successfully",
        "code": 200
    },
    "data": {
        "current_page": 1,
        "data": [
            {
                "id": 1,
                "content": "Molestiae voluptas cum ullam accusantium fuga magnam. Unde eaque laboriosam autem dolor. Voluptatem aut vel inventore.",
                "name": "Greta Lehner",
                "team": "SA",
                "avatar_url": "/tmp/7c5266db2cd916e1af404a688980e4dd.jpg",
                "rating": "3.0",
                "likes": 1,
                "create_date": "03:55:AM 07-02-2018"
            },
            {
                "id": 15,
                "content": "Vel natus quo explicabo cupiditate autem dolor et aliquid. Maiores qui ea ut impedit nisi et temporibus. Rem libero porro iste perferendis. Consequatur unde dolor qui dolores.",
                "name": "Mr. Morris Glover V",
                "team": "PHP",
                "avatar_url": "/tmp/bb8ab0ad35b2ecfe6e23d5ed0aadbd39.jpg",
                "rating": "2.0",
                "likes": 0,
                "create_date": "03:55:AM 07-02-2018"
            }
        ],
        "first_page_url": "http://flappybook.tech/api/books/14/reviews?page=1",
        "from": 1,
        "last_page": 1,
        "last_page_url": "http://flappybook.tech/api/books/14/reviews?page=1",
        "next_page_url": null,
        "path": "http://flappybook.tech/api/books/14/reviews",
        "per_page": 10,
        "prev_page_url": null,
        "to": 2,
        "total": 2
    }
}
```
