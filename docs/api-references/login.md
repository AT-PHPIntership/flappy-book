## LOGIN API

### `Post` user login

```
/api/login
```
Login system successfully

#### Parameters
| Key | Type | Required | Description |
|---|---|---|---|
| email | String | required, email | email to login |
| password | String | required | password |

#### Request header
| Key | Value |
|---|---|
| Accept | application/json |
| Content-Type | application/json |

#### Sample Request body
```json
{
  "email": "hieu.le@asiantech.vn",
  "password": "Ahihihi"
}
```

#### Sample Response
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
        "expires_at": "2018-02-07 08:54:43",
        "created_at": "2018-02-01 09:04:57",
        "updated_at": "2018-02-07 06:53:46",
        "deleted_at": null
    }
}
```

### `Post` user login

```
/api/login
```
Login Fail

#### Parameters
| Key | Type | Required | Description |
|---|---|---|---|
| email | String | required, email | email to login |
| password | String | required | password |

#### Request header
| Key | Value |
|---|---|
| Accept | application/json |
| Content-Type | application/json |

#### Sample Request body
```json
{
  "email": "hieu.le@asiantech.vn",
  "password": "Ahihihihoho"
}
```

#### Sample Response
```json
{
    "meta": {
        "status": "failed",
        "code": 400,
        "messages": "email_or_password_not_correct"
    }
}
```
