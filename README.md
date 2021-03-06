#TVO - Destiny Clan Application
_Laravel 7 | VueJs 2.6 | VueRouter 3.4.3 | VueX 3.5.1_

## Before Installation

The project need an SSL connexion in `https://`, and sqlite3 extension enable in `php.ini`

## Installation

- Clone the repo in your project folder
- `git clone https://www.github.com/axl6409/tvo-spa.git`
- Go to in the folder
- `cd tvo-spa`
- Copy the .env.example in .env file
- `copy .env.example .env`

### Adapt the Database Informations
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tvo-spa
DB_USERNAME=root
DB_PASSWORD=****
```

### Download Dependency
- Install composer dependencies
- `composer install`
- Dump autoload
- `composer dump-autoload`
- Install npm dependencies
- `npm install`

### Create the Database
- Run migrations
- `php artisan migrate`
- Run Seeder
- `php artisan db:seed`

### Generate Keys
- Generate keys
- `php artisan key:generate`
- `php artisan jwt:secret`

### Storage Folder Link
- Link storage folder
- `php artisan storage:link`

### Start Web Server
- Start the webserver
  - `npm run watch` or `npm run dev`
  - Wait ...
  - `DONE Compiled successfully in 14530ms`
  
**If you're running the project with Laragon** (Easiest way, Recommended !)

- Make sure you're running the project with ssl encrypt, needed for Bungie API requests
- Activate & Enable sqlite3 plugin in PHP extensions

**If you're not running the project with Laragon**
- Run laravel artisan server
- `php artisan serve`
- `Laravel Development server started: https://127.0.0.1:443`

## Initialisations

Somes files stored in the AddOns folder are required, also follow thoses steps to initialise the project:

1. Socialite Files
    - Copy `BungieProvider.php` in : `/vendor/laravel/socialite/src/Two/`
    - Copy & Replace `AbstractUser.php` in : `/vendor/laravel/socialite/src/`
    - Copy & Replace `User.php` in : `/vendor/laravel/socialite/src/Contracts/`

2. Unzip the manifest
    - Unzip the manifest archive in : `database/sqlite/manifest/world_sq_content_******************.zip`
    - Rename the unziped file extension in : `.sqlite`
    
2. First Connexion
    - Connect a new user on the "register" page (you need a Bungie.net account)
    - Go to the database on user table, then modify the `role_id` column to `1`, that make the user as an administrator
    
3. Make sure the `DB_SQLITE_PATH` in `.env` file is good or similar to this :
    - `DB_PATH_SQLITE=C:\laragon\www\tvo-spa-t3\database\sqlite\manifest\`
    - `DB_DATABASE_SQLITE=C:\laragon\www\tvo-spa-t3\database\sqlite\manifest\world_sql_content_b3c57463df24a92030b91752c2a97e14.sqlite`
