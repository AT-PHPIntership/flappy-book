## Users API

### `GET` information User
```
/api/users/{id}
```
Get information of user
#### Request Headers
| Key | Value |
|---|---|
|Accept|application\json
|Authorization|{token_type} {access_token}|

#### Parameter
| Field | Type | Description |
|-------|------|-------------|
| id | Number | Id of user |


#### Response - Success
| Field | Type | Description |
|-------|------|-------------|
| meta | Object | object meta |
| status | String | Status result |
| code | Number | HTTP status codes |
| data | Object | Object user |
| id | Number | Id of user |
| name | String | Name of user |
| employ_code | String | Employee code of user |
| email | String | Email of user |
| team | String | Team of user |
| avatar_url | String | Url for avatar of user |
| is_admin | Number | Are user an administrator |
| created_at | String | Create user time |
| updated_at | String | Update user time |
| book_borrowing | Object | The book, which user is borrowing |
| id | Number | id of book |
| title | String | title of book |
| picture | String | picture of book |
| total_rating | Number | total rating of book |
| rating | Number | rating of book |
| donated | Object | Object books donated by user |
| amount | Number | Number of books donated by user |
| borrowed | Object | Object books borrowed by user |
| amount | Object | Number of books donated by user |

```json
{
    "meta": {
        "status": "successfuly",
        "code": 200
    },
    "data": {
        "id": 1,
        "name": "Thanh Nguyen V.",
        "employ_code": "AT0069",
        "email": "thanh.nguyen@asiantech.vn",
        "team": "PHP",
        "avatar_url": "http://172.16.110.17/images/user/avatar/379/af86cf4f12.png",
        "is_admin": 0,
        "created_at": "2018-03-09 08:41:36",
        "updated_at": "2018-03-09 08:41:36",
        "book_borrowing": {
            "id": 11,
            "title": "Nicolas Cruickshank",
            "picture": "http://flappybook.tech/images/books//tmp/f740094a2657ee1518ea33cf24510c27.jpg",
            "total_rating": 11,
            "rating": 4
        },
        "donated": {
            "amount": 2
        },
        "borrowed": {
            "amount": 1
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
        "message": "data not found"
    }
}
```
```json
{
    "meta": {
        "status": "failed",
        "code": 401
    },
    "error": {
        "message": "Unauthorized"
    }
}
```
### `GET` Books of user donated
```
/api/users/{id}/donated
```
List books of user donated
#### Request Headers
| Key | Value |
|---|---|
|access-token|{token_type} {access_token}|

#### Parameter
| Field | Type | Description |
|-------|------|-------------|
| id | Number | Id of user |


#### Response - Success
| Field | Type | Description |
|-------|------|-------------|
| meta | Object | Object meta |
| status | String | Status result |
| code | Number | HTTP status codes |
| data | Array | List books of user donated |
| id | Number | Id of book |
| title | String | Title of book |
| description | String | Description of book |
| language | String | Language of book |
| rating | Number | Average review of a book |
| total_rating | Number | The total number of reviews of a book |
| picture | String | Picture of book |
| author | String | Author of book |
| price | Number | Price of book |
| unit | String | Unit of price |
| year | Number | Year of publication |
| page_number | Number | Pages number of book |

```json
{
    "meta": {
        "status": "Successfuly",
        "code": 200
    },
    "data": [
        {
            "id": 7,
            "title": "Code dạo ký sự",
            "description": "<p>CDKS</p>",
            "language": "VI",
            "rating": 4.0,
            "total_rating": 5,
            "picture": "http://book.aug/images/books/20180209.jpeg",
            "author": "Phạm Huy Hoàng",
            "price": 150000.00,
            "unit": "VND",
            "year": 2016,
            "page_number": 320,
        }
        {
            "id": 11,
            "title": "Clean Code",
            "description": "<p>Even bad code can function. But if code isn't clean, it can bring a development organization to its knees. Every year, countless hours and significant resources are lost because of poorly written code. But it doesn't have to be that way</p>",
            "language": "EN",
            "rating": 5.0,
            "total_rating": 1,
            "picture": "http://book.aug/images/books/30180209.jpeg",
            "author": "Robert Cecil Martin",
            "price": 31.19,
            "unit": "$",
            "year": 2008,
            "page_number": 500,
        }
        {
            "id": 13,
            "title": "Design Patterns for Dummies",
            "description": "<p>There's a pattern here, and here's how to use it! Find out how the 23 leading design patterns can save you time and trouble Ever feel as if you've solved this programming problem before?</p>",
            "language": "EN",
            "rating": 3.5,
            "total_rating": 2,
            "picture": "http://book.aug/images/books/24180209.jpeg",
            "author": "Steven Holzner",
            "price": 8.51,
            "unit": "$",
            "year": 2006,
            "page_number": 250,
        }
    ]
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
        "status": "Failed",
        "code": 404
    },
    "error": {
        "message": "data not found"
    }
}
```
```json
{
    "meta": {
        "status": "Failed",
        "code": 401
    },
    "error": {
        "message": "Unauthorized"
    }
}
```
