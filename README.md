# Sasaki Scheduler

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

### Resposne Body

```json
{
  "status": true
}
```

### POST `/api/event_date_users/<user_id>`

候補日に対してユーザーが出席できるかどうかを登録する API

#### Request Body

```json
{
  "event_id": 1,
  "status": 1
}
```

#### Response Body

```json
{
  "status": true
}
```

### UPDATE `/api/event_date_users/<user_id>`

候補日に対してユーザーが出席できるかどうかの更新をする API

#### Request Body

```json
{
  "event_id": 1,
  "status": 1
}
```

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
