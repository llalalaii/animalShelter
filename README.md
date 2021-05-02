# Animal Shelter

An application that monitors rescued animals health and progress as well as their rescuers and adopters.

## Installation

-   Create a database named db_felipe
-   Rename .env.example to .env
-   Make sure that the .env database is properly configured
-   Make sure that .env APP_NAME is "El's Animal Shelter"

Install composer dependencies

```
composer install
```

Generate application key

```
php artisan key:generate
```

Migrate and seed

```
php artisan migrate
```

```
php artisan db:seed
```

or

```
php artisan migrate --seed
```

Link storage folder to public folder

```
php artisan storage:link
```

Install npm dependencies

```
npm install
```

```
npm run dev
```

Finally,

```
php artisan serve
```

```
email: user@gmail.com
password: qwerty
```

Enjoy!
