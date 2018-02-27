## Comment Api
### `GET` Comments for Book or Post
```
/api/comments
```
Comments for Book

#### Request Headers

| Key | Value |
|---|---|
|Accept|application\json
#### Parameters
| Key | Type | Required | Description |
|---|---|---|---|
| commentable_type | String | required | Type of object |
| commentable_id | Number | required | Id of book or post |
#### Response
```json
{
    "data": [
        {
            "id": 1,
            "content": "Molestiae voluptas cum ullam accusantium fuga magnam.",
            "username": "Greta Lehner",
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
    "meta": {
        "pagination": {
            "total": 12
            "count": 2,
            "per_page": 10,
            "current_page": 2,
            "total_page": 2,
            "link": {
                "prev": "http://flappybook.tech/books/1/comments?page=1",
                "next": null,
            }
        }
        "status": "successfully",
        "code": 200
    }
}
```
