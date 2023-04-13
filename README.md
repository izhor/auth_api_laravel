Project documentation

1. Run the following command:
    - php artisan key:generate
    - composer require tymon/jwt-auth
    - php artisan migrate
    - php artisan db:seed --class=UserSeeder
    - php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
    - php artisan jwt:secret

2. there are several function i have been built by myself to keep the code simple and not repetitive, here are the following:
    - apiResponse()
        - consist with 2 parameter: first parameter is the HTTP response code such as 200, 400, 401, 404, 409, etc
        second parameter is the message, you can either put only string, or an array.
        example = > Controller::apiResponse(200,"Login attempt successfull")
        you can see this functions in app/Http/Controllers/Controller.php
        
3. if you want to run the project at port 3000, you can simply run the following command:
    - php artisan serve --port=3000
       