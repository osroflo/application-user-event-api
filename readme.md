# Application User Event API
The main goal of this API is to manage user events that happens in any application. User event is any action executed by the user also known as user activity log. The user event also can send notification by email and potentially by text messages. This API is running on laravel/lumen and it is the bridge to allow communication between an application and client.

![notification process](https://user-images.githubusercontent.com/5614506/38152606-7c704344-341d-11e8-98fc-ced05bc7a2f4.jpeg)

## Rationale
This API is designed to
- Track any user event (create, update, delete actions).
- Send and manage notification about events.
- The api can be used/integrated by any application.

## API Designer with Swagger
Files:
- Swagger configuration file is store in: docs/swagger.yaml
- package.json

How to launch the swagger editor using the event-api yaml configuration file:
```bash
# make sure swagger is installed globally
npm install -g swagger

# open the editor
npm run-script edit
```

## Pre-requisites

- PHP 5.6.4 >
- Apache Web Server
- [Lumen 5.4](https://lumen.laravel.com/docs/5.4)



## How to install the API in your local environment:

1 - Clone this repository.

2 - Setup virtualhost.

3 - Run composer install.

4 - Get a copy of the .env file in the infra repo.

5 - Setup database
```
 php artisan migrate
```

6 - Seed database
```
php artisan db:seed
```

7 - Test it
```
http://local.api.com/event/v1
http://local.api.com/event/v1/ping
```


## Disclaimer
This is just a sample code.
