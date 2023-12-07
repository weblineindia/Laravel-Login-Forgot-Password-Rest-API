
## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 1500 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).
## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](LICENSE).

## Installation

Clone the repository

    git clone https://github.com/weblineindia/Laravel-Login-Forgot-Password-Rest-API.git

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate


Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

Generate a new passport authentication secret key

    composer require laravel/passport

    php artisan migrate

    php artisan passport:install


**General command list**

    git clone https://github.com/weblineindia/Laravel-Login-Forgot-Password-Rest-API.git    
    composer install
    cp .env.example .env
    php artisan key:generate
    php artisan migrate
    composer require laravel/passport
    php artisan migrate
    php artisan passport:install
    
- `php artisan down` -> This command will put the maintenance mode screen if any page is accessed but won't bypass any functionality.
- `php artisan up` -> This command will bring the website back online and functionality to access everything.

- Cache clear commands to use in root of the project if any changes done in routes folder files or clear cache for the project.


        php artisan cache:clear
        php artisan route:clear
        php artisan route:cache
        php artisan view:clear
        php artisan config:clear
        php artisan config:cache
## Database Set up

- Access the database using UI access or commandline and export it to some directory.
- Create new database on new database server.
- Update .env configuration file with database credentials.

**Make sure you set the correct database connection information before running the migrations** [Environment variables](#environment-variables)

    php artisan migrate

## Folders
### Laravel 
- `app` - Contains all the Eloquent models
- `app/Http/Controllers/Api` - Contains all the api controllers
- `app/Http/Middleware` - Contains the auth middleware
- `database/migrations` - Contains all the database migrations
- `routes/api` - Contains all the api routes defined in api.php file

### Execute Laravel Code
- Use below command
    
        php artisan serve
- Above command will start laravel project running
- Use the URL from the terminal and paste it in the web browser

## Environment variables

- `.env` - Environment variables can be set in this file

***Note*** : You can quickly set the database information and other variables in this file and have the application fully working.
# Authentication
 
This applications uses OAuth Tiken to handle authentication. The token is passed with each request using the `Authorization` header with `Token` scheme. The authentication middleware handles the validation and authentication of the token. Please check the following sources to learn more about Passport.
 
- https://laravel.com/docs/8.x/passport

## Contact

We have built many other components and free resources for software development in various programming languages. Kindly click here to view our [Free Resources for Software Development](https://www.weblineindia.com/communities.html).

---

Happy coding! 😊