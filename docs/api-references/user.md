## List status of user Api

### Get list status of user

```
/api/users/{id}

```
Get list all status of user with paginate
#### Request header 
| Key | Value |
|---|---|
|Accept|application\json
#### Parameters
| Key | Value | Required | Description |
|---|---|---|---|
| id | Interger | required | Id of user |

#### Response - Success
| Field | Type | Description |
|---|---|---|
| data | Object | Object posts |
| id | Number | Id of status |
| content | String | Content of status |
| status | Number | status of status |
| user_id | Number | Id of user |
| created_at | DateTime | Create date of the status |
| updated_at | DateTime | Update date of the status |
| deleted_at | DateTime | Delete date of the status |
| meta | Object | Object meta |
| total | Number | Total item |
| count | Number | Total item on current page |
| per_page | Number | Total item on per page |
| current_page | Number | Current page |
| total_page | Number | Total page |
| link | Url | Page url |
| status | String | Status result |
| code | Number | HTTP status code |

```json
{
	"data": [
		{
			"id":1,
			"content": "Et excepturi ipsa iusto repellat molestiae. Aut esse voluptatum omnis dignissimos pariatur et.",
			"status":1,
			"user_id":1,
			"created_at": "2018-02-08 07:35:34",
			"updated_at": "2018-02-10 08:35:30",
			"deleted_at": null,
		},
		{
			"id":3,
			"content": "Et excepturi ipsa iusto repellat molestiae. Aut esse voluptatum omnis dignissimos pariatur et.",
			"status":0,
			"user_id":1,
			"created_at": "2018-01-08 07:35:34",
			"updated_at": "2018-02-10 08:35:30",
			"deleted_at": null,
		},
		{
			"id":8,
			"content": "Et excepturi ipsa iusto repellat molestiae. Aut esse voluptatum omnis dignissimos pariatur et.",
			"status":2,
			"user_id":1,
			"created_at": "2018-02-20 07:35:34",
			"updated_at": "2018-02-22 08:35:30",
			"deleted_at": null,
		}
	],
	"meta": {
		"pagination": {
			"total": 25,
			"count": 20,
			"per_page": 20,
			"curent_page": 1,
			"total_page": 2,
			"link": {
				"prev": "http://flappybook.tech/users/1?page=1",
				"next": null,
			}
		},
		"status": "Successfully",
		"code": 200
	}
}
```
#### Response - Fail
| Field | Type | Description |
|---|---|---|
| meta | Object | Object meta |
| status | String | Status result |
| code | Number | HTTP status code |
| error | Object | Object error |
| message | String | Error message |

```json
{
	"meta": {
		"status": "Failed",
		"code": 404,
	},
	"error": {
		"message": "Page not found!",
	}
}
```
