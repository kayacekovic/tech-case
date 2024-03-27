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

## Get Tasks
Run the following code to get tasks from provider(s).
```
php artisan tasks:get-tasks-from-providers
```

If want to get tasks from specific provider, need to add --provider option to command. 
Can see all providers in TaskProviders.php. 
```
php artisan tasks:get-tasks-from-providers --provider=jira
```


## Task Assigment
Run the following code to assign tasks to developers that are not yet assigned.
If there is no active sprint yet, it creates a sprint from the nearest working day.
```
php artisan tasks:assign-tasks-to-developers
```
