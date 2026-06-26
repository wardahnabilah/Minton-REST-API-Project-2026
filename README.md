# Minton Booking REST API
#### REST API built with Laravel 12 for minton - badminton court booking app

## Features
- Authentication (Register, Login, Logout) using Laravel Sanctum API token
- CRUD courts, court schedules, bookings

## Base URL
```
http://your-domain.com/api/v1
```

## Headers
```http
Content-Type: 'application/json',
Accept: 'application/json',
Authorization: 'Bearer {token}' 
```
> `Authorization` is required for all endpoints except `/register` and `/login`

## Endpoints
### Register
| Method | Endpoint | Description  |
|----- |-------- | ------- |
|POST | /register | Create new user |

#### Example Request
``` 
{
    "name": "test",
    "email": "test@mail.com",
    "password": "12345678",
    "password_confirmation": "12345678"
}
```
#### Example Response Success
```
{
    "success": true,
    "message": "user created successfully",
    "data": {
        "id": 1,
        "name": "test"
    }
}
```
#### Example Response Error
```
{
    "success": false,
    "message": "Validation failed",
    "errors": {
        "email": [
            "The email has already been taken."
        ],
        "name": [
            "The name field is required."
        ],
        "password": [
            "The password field must be at least 8 characters."
        ]
    }
}
```
### Login
| Method | Endpoint | Description  |
|----- |-------- | ------- |
| POST | /login | user log in |

#### Example Request
``` 
{
    "email": "test@mail.com",
    "password": "12345678"
}

```
#### Example Response Success
```
{
    "success": true,
    "message": "user logged in successfully",
    "data": {
        "accessToken": "1|XI9gWCbw5Tm4K0GtgV5ZoCmqCHCr29zvZ0Fp5WcRa4cb0af0"
    }
}

```
#### Example Response Error
```
{
    "success": false,
    "message": "invalid email and/or password"
}
```
### Logout
| Method | Endpoint | Description  |
|----- |-------- | ------- |
| POST | /logout | user log out |

#### Example Response Success
```
{
    "success": true,
    "message": "user logged out successfully",
    "data": []
}
```

### Courts API
##### * can only be accessed by users with admin role 
| Method | Endpoint | Description  |
|----- |-------- | ------- |
|GET | /courts | Get all courts |
|POST | /courts | Create new court |
|PUT  |  /courts/{id} | Update court |
|DELETE | /courts/{id} | Delete court |

- GET /courts
    #### Example Response
    ```
    {
        "success": true,
        "message": "data retrieved successfully",
        "data": [
            {
                "id": 1,
                "name": "Court A",
                "court_schedule": {
                    "id": 1,
                    "court_id": 1,
                    "day": "tuesday",
                    "open_time": "09:00",
                    "close_time": "11:00",
                    "created_by": 1,
                    "updated_by": null,
                    "deleted_by": null,
                    "created_at": "2026-06-11T16:11:07.000000Z",
                    "updated_at": "2026-06-11T16:11:07.000000Z",
                    "deleted_at": null
                },
                "schedules": [
                    {
                        "day": "tuesday",
                        "start_time": "09:00",
                        "end_time": "10:00",
                        "status": "booked"
                    },
                    {
                        "day": "tuesday",
                        "start_time": "10:00",
                        "end_time": "11:00",
                        "status": "available"
                    }
                ]
            },
            {
                "id": 2,
                "name": "Court B",
                "court_schedule": {
                    "id": 13,
                    "court_id": 5,
                    "day": "wednesday",
                    "open_time": "06:00",
                    "close_time": "07:00",
                    "created_by": 2,
                    "updated_by": null,
                    "deleted_by": null,
                    "created_at": "2026-06-12T13:55:08.000000Z",
                    "updated_at": "2026-06-12T13:55:08.000000Z",
                    "deleted_at": null
                },
                "schedules": [
                    {
                        "day": "wednesday",
                        "start_time": "06:00",
                        "end_time": "07:00",
                        "status": "available"
                    }
                ]
            }
        ]
    }
    ```
- POST /courts
    #### Example Request 
    ``` 
    {
        “name”: “Court A”
    }
    ```
    #### Example Response 
    ```
    {
        "success": true,
        "message": "court created successfully",
        "data": {
            "id": 1,
            "name": "Lapangan A"
        }
    }
    ```
- PUT /courts/{id}
    #### Example Request 
    ``` 
    {
        “name”: “Court A edit”
    }
    ```
    #### Example Response 
    ```
    {
        "success": true,
        "message": "court successfully updated",
        "data": {
            "id": 1,
            "name": "Court A edit",
        }
    }
    ```
- DELETE /courts/{id}
    ```
    {
        "success": true,
        "message": "court successfully deleted",
        "data": null
    }
    ```

### Schedules API
##### * can only be accessed by users with admin role 
| Method | Endpoint | Description  |
|----- |-------- | ------- |
|POST | /schedules | Create new court schedules |
|PUT  |  /schedules/{id} | Update court schedule |
|DELETE | /schedules/{id} | Delete court schedule |

- POST /schedules
    #### Example Request 
    ``` 
    {
        "court_id": "1",
        "day": "monday", 
        "open_time": "07:00",
        "close_time": "10:00"
    }
    ```
    #### Example Response 
    ```
    {
        "success": true,
        "message": "court schedule created successfully",
        "data": {
            "id": 5,
            "day": "monday",
            "open_time": "07:00",
            "close_time": "10:00"
        }
    }
    ```
- PUT /schedules/{id}
    #### Example Request 
    ``` 
    {
        "court_id": "1",
        "day": "monday", 
        "open_time": "07:00",
        "close_time": "09:00"
    }
    ```
    #### Example Response 
    ```
    {
        "success": true,
        "message": "court schedule updated successfully",
        "data": {
            "id": 5,
            "day": "monday",
            "open_time": "07:00",
            "close_time": "09:00"
        }
    }
    ```
- DELETE /schedules/{id}
    #### Example Response 
    ```
    {
        "success": true,
        "message": "court schedule deleted successfully",
        "data": null
    }
    ```

### Bookings API
##### * can only be accessed by users with admin role 
| Method | Endpoint | Description  |
|----- |-------- | ------- |
|GET | /bookings | Get all bookings |
|POST | /bookings | Create new booking |
|GET  |  /bookings/{id} | Get booking by id |
|DELETE | /bookings/{id} | Cancel booking |

- GET /bookings
    ```
    {
        "success": true,
        "message": "booking data retrieved successfully",
        "data": [
            {
                "id": 6,
                "user_id": 2,
                "court_schedule_id": 2,
                "start_time": "08:00:00",
                "end_time": "09:00:00"
            },
            {
                "id": 7,
                "user_id": 2,
                "court_schedule_id": 1,
                "start_time": "07:00:00",
                "end_time": "08:00:00"
            }
        ]
    }
    ```
- POST /bookings
    #### Example Request 
    ``` 
    {
        "court_schedule_id": "1", 
        "start_time": "07:00",
        "end_time": "08:00"
    }
    ```
    #### Example Response 
    ```
    {
        "success": true,
        "message": "booking created succesfully",
        "data": {
            "id": 7,
            "user_id": 2,
            "court_schedule_id": "1",
            "start_time": "07:00",
            "end_time": "08:00"
        }
    }
 - GET /bookings/{id}
    #### Example Response 
    ```
    {
        "success": true,
        "message": "booking detail retrieved successfully",
        "data": {
            "id": 6,
            "user_id": 2,
            "court_schedule_id": 13,
            "start_time": "07:00:00",
            "end_time": "08:00:00"
        }
    }
    ```
 - DELETE /bookings/{id}
    #### Example Response 
    ```
    {
        "success": true,
        "message": "booking deleted successfully",
        "data": null
    }
    ```

