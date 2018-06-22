# Sasaki Scheduler 

## Models

### users

* user_id: primary
* email: text
* name: text

### events
* title: text
* description: text
* locale: text
* event_type_id: ref

### event_types ( 春合宿, 新歓等 )
* event_type_id: primary
* name: text

### event_users ( Eventに参加しているユーザー )
* user_id: ref
* event_id: ref
* invited: bool

### event_dates ( イベント候補日 )
* event_id: ref
* prospective_date: date
* prospective_time: time

### event_date_users (イベント候補日に対するユーザーの出席確認 )
* event_date_id: ref
* user_id: ref
* status: enum

## APIs
### GET `/api/events`
イベント一覧を返す

#### Response Body

```json
[
  {
    "event_id": 1,
    "title": "2018年度 夏合宿",
    "description": "2018年度夏合宿の出席登録です",
    "locale": "大沢温泉",
    "event_type": "夏合宿",
    "event_users": [
      {
        "user_id": 1,
        "name": "TaikiFnit",
        "email": "g031o167@s.iwate-pu.ac.jp"
      }
    ],
    "event_dates": [
      {
        "event_date": "2018/06/12",
        "event_time": "19:00",
        "users": [
          {
            "user_id": 1,
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
  "event_type_id": 1,
  "event_user_ids": [1,2,3,4,5],
  "event_dates": [
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