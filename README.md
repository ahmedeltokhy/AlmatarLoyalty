<p>used Framework PHP Laravel 8</p>
<ul>
<li>rename  .env.example to .env  to copy example into real .env file, then edit it with DB credentials and other settings you want</li>
<li>Run composer install command</li>
<li>Run php artisan migrate --seed command. Seed is important, because it will create the first admin user for you.</li>
<li>Run php artisan key:generate command</li>
<li>run the command php artisan serve. to start serving the project.</li> 
</ul>