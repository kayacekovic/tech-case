Case Study
---

### Installation

- Clone the project to local repository.
- Copy `.env.example` file as `.env` file and fill your parameters
- Set database configuration on .env

```
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=database_name
DB_USERNAME=username
DB_PASSWORD=password
```
- Run `composer install`
- Run `yarn install`
- Run `yarn dev` or `yarn build`

### Import Tables To Database (With Seed)

````
php artisan migrate

php artisan db:seed
````

## Task Assigment
Run the following code to assign tasks to developers that are not yet assigned. 
If no active sprint has been created yet, it creates a sprint from the nearest working day.
```
php artisan tasks:assign-tasks-to-developers
```
