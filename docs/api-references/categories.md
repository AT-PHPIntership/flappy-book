## Categories API

### `GET` Categories
```
/api/categories
```
Get list categories

#### Response - Success
| Field | Type | Description |
|-------|------|-------------|
| meta | Object | object meta |
| status | String | Status result |
| code | Number | HTTP status codes |
| data | Array | List Categories |
| id | Number | Id of category |
| title | String | Title of category |

```json
{
    "meta": {
        "status": "successfuly",
        "code": 200
    },
     "data": [
        {
            "id": 7,
            "title": "Alvera Ortiz"
        },
        {
            "id": 8,
            "title": "Dr. Jameson Sporer"
        },
        {
            "id": 5,
            "title": "Dr. Leopold Jaskolski"
        },
        {
            "id": 6,
            "title": "Josefina Parker"
        },
        {
            "id": 10,
            "title": "Miss Myriam Fadel"
        },
        {
            "id": 1,
            "title": "Prof. Isaiah Lubow ahihi"
        },
        {
            "id": 4,
            "title": "Savion Walsh"
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
        "status": "failed",
        "code": 404
    },
    "error": {
        "message": "Page not found!"
    }
}
```
