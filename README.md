Git checkout the project

copy .env.example and create .env

uncomment the following from .env

# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=laravel
# DB_USERNAME=root
# DB_PASSWORD=

navigate to your `admin-forms` project folder

php artisan migrate // do the migrations

php artisan db:seed //seeding admin data

npm install && npm run build

php artisan serve // will point to a url where the application loads

php artisan queue:work //for sending an email notification via job on queue after creation of dynamic forms

When the Application loads, Login using :

username : admin@admin.com

password : Adminadmin@11

Try creating Dynamic forms from the create button on `http://localhost:8000/admin/forms` page

Created Forms are publically visible from the URL `http://localhost:8000/forms`


