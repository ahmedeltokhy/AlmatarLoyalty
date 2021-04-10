used Framework PHP Laravel 8
rename  .env.example to .env  to copy example into real .env file, then edit it with DB credentials and other settings you want
Run composer install command
Run php artisan migrate --seed command. Seed is important, because it will create the first admin user for you.
Run php artisan key:generate command
run the command php artisan serve. to start serving the project. 