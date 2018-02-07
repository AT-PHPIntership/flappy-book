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
  "current_page": 1,
  "data": [
    {
      "id": 1,
      "content": "Ut quia quis cum quibusdam et. Ex a odit quia quis. Vero molestiae expedita in unde dicta.",
      "name": "Thurman Will",
      "team": "SA",
      "avatar_url": "/tmp/7ac1bd4a971281d8aa9a1d6b4e8553ba.jpg",
      "rating": "2.0",
      "likes": 3,
      "create_date": "10:35:AM 06-02-2018"
    },
    {
      "id": 2,
      "content": "Id aperiam earum molestiae nulla. Perferendis nostrum et sapiente possimus vitae voluptatem sint. Quam sed pariatur itaque assumenda deserunt ratione. Et modi blanditiis rem voluptas deserunt.",
      "name": "Raheem Nitzsche",
      "team": "PHP",
      "avatar_url": "/tmp/27cf653692da907ba157ab067f7a119c.jpg",
      "rating": "2.0",
      "likes": 4,
      "create_date": "10:35:AM 06-02-2018"
    },
    {
      "id": 3,
      "content": "Reiciendis itaque ea molestiae maiores perferendis veniam qui. Dolor aut velit sint sit sit. Beatae hic dicta sunt odit pariatur earum. Autem rerum voluptatum rerum.",
      "name": "Raheem Nitzsche",
      "team": "PHP",
      "avatar_url": "/tmp/27cf653692da907ba157ab067f7a119c.jpg",
      "rating": "5.0",
      "likes": 1,
      "create_date": "10:35:AM 06-02-2018"
    },
    {
      "id": 4,
      "content": "Consequatur tempora maiores enim earum. Magni magnam ut quis minus pariatur maxime fugit quod. Aut dicta est eos et odit quae.",
      "name": "Brendan Boyer",
      "team": "PHP",
      "avatar_url": "/tmp/5a35bc35c14e620f8d31475523b9897a.jpg",
      "rating": "3.0",
      "likes": 1,
      "create_date": "10:35:AM 06-02-2018"
    },
    {
      "id": 5,
      "content": "Aut voluptas et illo dolorum repellat. Optio omnis minima expedita debitis molestias quasi deserunt. Nesciunt et et et fuga. Est pariatur neque fuga.",
      "name": "Dereck Konopelski",
      "team": "ANDROID",
      "avatar_url": "/tmp/4bfaa019904db355f1798d2be62599e5.jpg",
      "rating": "5.0",
      "likes": 2,
      "create_date": "10:35:AM 06-02-2018"
    },
    {
      "id": 6,
      "content": "Aut et et non hic dicta. Rerum molestiae iste nostrum eveniet. Ut quia mollitia doloremque quia et.",
      "name": "Jerrell Casper Jr.",
      "team": "ANDROID",
      "avatar_url": "/tmp/51598350a0eaf424914662f864227c58.jpg",
      "rating": "3.0",
      "likes": 4,
      "create_date": "10:35:AM 06-02-2018"
    },
    {
      "id": 7,
      "content": "Facilis sunt accusamus qui porro. Eaque dolores dolor exercitationem facilis dolores voluptates. Et est iusto voluptas.",
      "name": "Raheem Nitzsche",
      "team": "PHP",
      "avatar_url": "/tmp/27cf653692da907ba157ab067f7a119c.jpg",
      "rating": "5.0",
      "likes": 0,
      "create_date": "10:35:AM 06-02-2018"
    },
    {
      "id": 8,
      "content": "Voluptatem dolorem et quae voluptas deleniti provident quis. Necessitatibus amet reprehenderit est velit maiores. Omnis nobis esse error architecto.",
      "name": "Carolanne Stanton III",
      "team": "BO",
      "avatar_url": "/tmp/1bc5a474ad1eaf00f7de22305484a8a9.jpg",
      "rating": "2.0",
      "likes": 3,
      "create_date": "10:35:AM 06-02-2018"
    },
    {
      "id": 9,
      "content": "In id itaque est aut. Laboriosam autem dolore nesciunt odit inventore. Eum nihil quis quia enim.",
      "name": "Dereck Konopelski",
      "team": "ANDROID",
      "avatar_url": "/tmp/4bfaa019904db355f1798d2be62599e5.jpg",
      "rating": "5.0",
      "likes": 0,
      "create_date": "10:35:AM 06-02-2018"
    },
    {
      "id": 10,
      "content": "Cupiditate deleniti provident qui est ab praesentium. Iure aperiam hic est. Eius rerum aperiam veritatis minima officia qui.",
      "name": "Cao Nguyen V.",
      "team": "PHP",
      "avatar_url": "http://172.16.110.17/images/user/avatar/366/64314e61c9.png",
      "rating": "2.0",
      "likes": 2,
      "create_date": "10:35:AM 06-02-2018"
    }
  ],
  "first_page_url": "http://flappybook.tech/api/books/8/reviews?page=1",
  "from": 1,
  "last_page": 2,
  "last_page_url": "http://flappybook.tech/api/books/8/reviews?page=2",
  "next_page_url": "http://flappybook.tech/api/books/8/reviews?page=2",
  "path": "http://flappybook.tech/api/books/8/reviews",
  "per_page": 10,
  "prev_page_url": null,
  "to": 10,
  "total": 15
}
```
