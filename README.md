# Laravel test case

### Development
The database schema with separation of tables: **books**, **authors**, **publishers** and linking tables **books_authors**, **publishers_books** was created to implement the task. Linking tables are needed because publishers can print the same books and books can have the same authors. Linking tables connect publisher to books and books to authors, to avoid having the same entries in book or author tables, and to allow convenient sorting. 

Also, the controllers are divided into two parts: API and Front. The API controllers handle the **/api** routes, while Front handles the routes of the site itself.

The API processing logic is described in the code itself in the form of comments.

[API Documentation](https://app.swaggerhub.com/apis/SlamDevelop/Test-Library-Laravel/1 "API Documentation")

### Stack
- PHP 7.4.28
- Laravel 8.75
- Bootstarp 5.1.3

### Installing
1. `git clone SlamDevelop/Test-Library-Laravel`

1. Rename file` .env.example` to `.env`
1. Enter your data from the MySql server into the .env file
    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=laravel
    DB_USERNAME=root
    DB_PASSWORD=
    ```
1. Installing packages
`composer install`

1. Performing a database migration:
`php artisan migrate`

1. Generating a key for Laravel
`php artisan key:generate`

1. Running
`php artisan serve`
