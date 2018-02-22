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
| employ_code | String | Employee code of user |
| name | String | Name of user |
| team | String | Team of user |
| email | String | Email of user |
| is_admin | Number | Are user an administrator |
| avatar_url | String | Url for avatar of user |
| book_borrowing | String | The book, which user is borrowing |
| donated | Number | Number of books donated by user |
| borrowed | Number | Number of books borrowed by user |

```json
{
    "meta": {
        "status": "successfuly",
        "code": 200
    },
    "data": {
        "id": 1,
        "employ_code": "AT0069",
        "name": "Thanh Nguyen V.",
        "team": "PHP",
        "email": "thanh.nguyen@asiantech.vn",
        "is_admin": 0,
        "avatar_url": "http://172.16.110.17/images/user/avatar/379/af86cf4f12.png",
        "book_borrowing": "What up!",
        "donated": 2,
        "borrowed": 5,
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
