# Laravel APIs Task

This project is a simple Laravel RESTful API for user authentication using Laravel Sanctum.  
It includes user registration, login, logout, token handling, and clean API responses.

---

## Features

- User Registration with validation
- Login with token generation (Sanctum)
- Logout and token revocation
- Structured API response using a custom trait
- Validation via Form Requests
- Postman Collection included for easy testing

---

## Requirements

- PHP 8.1+
- Composer
- MySQL / MariaDB
- Laravel 10
- Postman (for testing)

---

## Setup Instructions

1. Clone the repository
   ```bash
   git clone https://github.com/AbdullahSayed3/Laravel_APIs_Task.git
   cd Laravel_APIs_Task

2.Install dependencies
 
  composer install


3. Copy .env file

    cp .env.example .env


4.Configure .env file

    Add your database credentials:

        DB_DATABASE=your_db_name
        DB_USERNAME=your_username
        DB_PASSWORD=your_password

5.Generate app key

    php artisan key:generate

6.Run migrations

    php artisan migrate

7.run the application
php artisan server


## API Endpoints
 
Method   	Endpoint	         Description	              Auth Required

POST	  /api/register	      Register a new user	                No

POST	   /api/login	     Log in with credentials	            No

POST      /api/logout	    Log out and revoke token	            Yes

## Postman Collection
You can import the Postman collection found in:

https://documenter.getpostman.com/view/39461690/2sB2xBDq2V



It includes all available endpoints for testing.

## Folder Structure
app/Http/Controllers/Api/Auth/AuthController.php → All auth methods

app/Http/Requests/RegisterRequest.php → Validation for registration

app/Http/Requests/LoginRequest.php → Validation for login

app/Http/Resources/UserResource.php → Clean user response

app/Traits/ApiResponse.php → Custom trait for API responses

## Author
Abdullah Sayed Abdelazeem Kamel