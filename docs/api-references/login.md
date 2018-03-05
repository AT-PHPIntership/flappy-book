## Login Api

### `POST` User Login

```
/api/login
```
Login api

#### Parameters
| Key | Type | Required | Description |
|---|---|---|---|
| email | String | required | Email to login |
| password | String | required | Password |

#### Response - Success
```json
{
    "meta": {
        "status": "successfully",
        "code": 200
    },
    "data": {
        "id": 1,
        "employ_code": "ATI0290",
        "name": "Hieu Le T.",
        "email": "hieu.le@asiantech.vn",
        "team": "PHP",
        "avatar_url": "http://172.16.110.17/images/user/avatar/373/1eb050875d.png",
        "is_admin": 1,
        "access_token": "f0ec55260f410328e98b35836e4624c6",
        "created_at": "2018-02-01 09:04:57",
        "updated_at": "2018-02-07 06:53:46",
    }
}
```

#### Response - Fail
```json
{
    "meta": {
        "status": "failed",
        "code": 400,
    },
    "error": {
        "messages": [
            "email_or_password_not_correct"
        ]
    }
}
```
