# Sasaki Scheduler

* API Server: https://sasaki-scheduler.herokuapp.com/
* API Mock Server: https://25d13173-dfe1-498e-9f0f-0f0e8f79ca91.mock.pstmn.io
* API stubs: https://documenter.getpostman.com/view/548209/RWM8UCFR  
* Client: https://github.com/TaikiFnit/sasaki-scheduler-client

## APIs 

### GET `/api/events`

イベント一覧を返す

#### Response Body

```json
[
  {
    "id": 1,
    "title": "2018年度 夏合宿",
    "description": "2018年度夏合宿の出席登録です",
    "locale": "大沢温泉",
    "type": "夏合宿",
    "users": [
      {
        "id": 1,
        "name": "TaikiFnit",
        "email": "g031o167@s.iwate-pu.ac.jp"
      }
    ],
    "dates": [
      {
        "date": "2018/06/12",
        "time": "19:00",
        "users": [
          {
            "id": 1,
            "name": "TaikiFnit",
            "status": "○"
          }
        ]
      }
    ]
  }
]
```

### POST `/api/events`

#### Request Body

```json
{
  "title": "2018年度 夏合宿",
  "description": "2018年度夏合宿の出席登録です",
  "locale": "大沢温泉",
  "type_id": 1,
  "user_ids": [1, 2, 3, 4, 5],
  "dates": [
    {
      "date": "2018/06/12",
      "time": "19:00"
    }
  ]
}
```

#### Resposne Body

```json
{
  "status": true
}
```

### POST `/users`

ClientでGoogle OAuthしたtoken情報をDBにStoreする

#### Request Body

```json
{
    "googleId": "123456789...",
    "tokenId": "token",
    "accessToken": "access_token",
    "email": "g031@s.iwate"
    }
```

#### Response Body 

```json
{
  "status" : true,
  "user": {
    "id":1,
    "name":"TaikiFnit",
    "family_name":"Fnit",
    "given_name":"Taiki",
    "picture":"https://photo.jpg",
    "email":"g031o@s.iwate-pu",
    "token_id":"eyJhbGciOiz",
    "google_id":"111796",
    "access_token":"ya29.Glz0BUi_d3mtkApzPQ",
    "created":"2018-07-10T03:24:55+00:00",
    "modified":"2018-07-10T03:27:24+00:00"
  }
}
```

### GET `/users/view/:access_token`

Access Token をもとに, ユーザーIDを含むユーザー情報を返す. 

### Response Body

```


```

### GET `/api/event_date_users/<access_token>`
 
ユーザーが入力した出席登録を取得するAPI 

#### Request Body

```json
{
  "event_id": 1
}
```

#### Response Body

```json
{
    "status": true,
    "event_date_users": [
        {
            "id": 1,
            "event_date_id": 1,
            "user_id": 1,
            "status": 1,
            "created": "2018-07-13T06:11:24+00:00",
            "modified": "2018-07-13T06:11:24+00:00"
        },
        {
            "id": 7,
            "event_date_id": 2,
            "user_id": 1,
            "status": 2,
            "created": "2018-07-17T08:43:00+00:00",
            "modified": "2018-07-17T08:43:00+00:00"
        }
    ]
}
```



### POST `/api/event_date_users/add/:event_date_id?access_token=<access_token>`

候補日に対してユーザーが出席できるかどうかを登録する API

#### Request Body

```json
{
  "status": 1
}
```

#### Response Body

```json
{
  "status": true,
  "event_date_user": {
    "id": 4,
    "user_id": 1,
    "event_date_id": 1,
    "status": 1,
    "created": "2018-07-17T07:29:38+00:00",
    "modified": "2018-07-17T07:29:38+00:00"
  }
}
```

### DELETE `/api/event_date_users/:event_date_userid?=access_token=<access_token>`

ユーザーが登録した出席状況を削除する API


#### Response Body

```json
{
  "status": true
}
```


## Models

### users

* id: integer
* email: string
* name: string
* grade: integer
* google_id: string
* google_token: string # for google login
* created: date
* modified: date
* (belongsToMany events through event_users)
* (belongsToMany event_dates through event_date_users)

### events

* id: integer
* title: sting
* description: string
* locale: string
* event_type_id: ref # belongsTo
* created: date
* modified: date
* (belongsToMany users through event_users)
* (hasMany event_dates)

### event_types ( 春合宿, 新歓等 )

* id: integer
* name: string
* created: date
* modified: date

### event_users ( Event に参加しているユーザー )

* id: integer
* user_id: ref # belongsTo
* event_id: ref # belongsTo
* invited: bool
* created: date
* modified: date

### event_dates ( イベント候補日 )

* id: integer
* event_id: ref # belongsTo
* prospective_date: date
* prospective_time: time
* created: date
* modified: date
* (belongsToMany users through event_date_users)

### event_date_users (イベント候補日に対するユーザーの出席確認 )

* id: integer
* event_date_id: ref # belongsTo
* user_id: ref # belongsTo
* status: integer
* created: date
* modified: date
