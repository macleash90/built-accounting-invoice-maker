## ABOUT BUILT ACCOUNTING INVOICE MAKER
This is a simple Invoice Maker built with Laravel 7, VueJs 2.x, Bootstrap 4, jQuery

## REQUIREMENTS
- Php version 7.3 or later but less than Php version 8
- NodeJS
- Mysql

## HOW TO RUN APP

1. Create database called built_invoice_maker and run `php artisan migrate` or manage your own database credentials in .env file
2. Run `composer install` to install php dependencies
3. Run `npm run install` to install javascript dependencies - (not neccessary if you don't wish to edit Javascript code)
4. Run `npm run watch` (in development) or `npm run production` (in production) to compile javascript code - (not neccessary if you don't wish to edit Javascript code)
5. Run `php artisan key:generate` to set the application key to a random string
6. Run `php artisan config:cache` to clear the application's cache
7. Run `php artisan serve --port=8090` to launch application, then visit 'localhost:8090' in browser to view app or simply doubleclick index.bat in the application's root (on Windows OS)
