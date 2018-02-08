## Post Api
### `GET` Reviews for Book
```
/api/books/{id}/reviews
```
Get Posts with status review for Book

#### Request Headers

| Key | Value |
|---|---|
|Accept|application\json
#### Parameters
| Key | Type | Required | Description |
|---|---|---|---|
| id | Integer | required | Id of book |
#### Response
```json
{
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
    "meta": {
        "pagination": {
            "total": 12,
            "count": 2,
            "per_page": 10,
            "current_page": 2,
            "total_pages": 2,
            "links": {
                "prev": "http://flappybook.tech/api/books/14/reviews?page=1",
                "next": null
            }
        },
        "status": "successfully",
        "code": 200
    }
}
```
