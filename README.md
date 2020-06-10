# kt-team (10-06-2020)

# Installation
This package utilizes Composer to manage its dependencies. Make sure you have Composer installed on your machine.
Then run the following commands in your terminal: 
1) The Laravel framework is required by this package. To install laravel, run the following command
- composer create-project --prefer-dist laravel/laravel task "6.2.*"
2) Change your directory to the newly created project. On windows the command is: 
- cd task
2) After laravel installation is complete, run the following command to install this package
- composer require drnkwati/task-tracker
3) change database configuration for your application in .env configuration file
- You may use any relational database supported by laravel framework. Just set the database connection and run migrations.
- For your convenience, this package comes with a demo sqlite database with seed data. 
- To use this demo database, update your .env database configuration connection to: DB_CONNECTION=taskTrackerDemo
4) You may use a web server such as Apache or Nginx to serve your applications. To use PHP's built-in development server. On windows run the following command: 
- php artisan serve --port=7070
5) Open your web browser at: http://127.0.0.1:7070/tasks

# Possible API endpoints include:
- http://127.0.0.1:7070/tasks/search
- http://127.0.0.1:7070/tasks
- http://127.0.0.1:7070/users/search
- http://127.0.0.1:7070/users
The api can be accessed through a tool such as postman. For simple http GET requests, you can use a web browser.

# Usage Examples: 
## The following queries assume you are using the demo database.
* When making PUT, PATCH or DELETE, you will need to add a hidden \_method field to the form

## Endpoint tasks/search at http://127.0.0.1:7070/tasks/search
### search (GET/POST)
- To search task with id = 3: http://127.0.0.1:7070/tasks/search/3 or http://127.0.0.1:7070/tasks/search?id=3
- To search and paginate tasks with status = active: http://127.0.0.1:7070/tasks/search?status=active
- To search and paginate tasks with status = completed, show = 5 from page 2: http://127.0.0.1:7070/tasks/search?show=5&page=2&status=completed
-  To search and paginate tasks with status = completed and user_id = 7: http://127.0.0.1:7070/tasks/search?user_id=7&status=completed

## Endpoint tasks at http://127.0.0.1:7070/tasks
### select (GET)
- To show 5 task per page: http://127.0.0.1:7070/tasks?show=5
- To show 5 task per page begining from page 2: http://127.0.0.1:7070/tasks?show=5&page=2
- To show task with id = 3: http://127.0.0.1:7070/tasks/3

### create (POST)
- To create a new task, make a POST request to: http://127.0.0.1:7070/tasks
- Required fields include user_id and title

### delete (DELETE)
- To delete an existing task, make a DELETE request to: http://127.0.0.1:7070/tasks/{id}
- Where {id} is the task id you wish to delete
- To delete task id = 11, make a DELETE request to: http://127.0.0.1:7070/tasks/11

### update (PUT/PATCH)
- To update an existing task, make a PUT or PATCH request to: http://127.0.0.1:7070/tasks/{id}
- Where {id} is the task id you wish to update
- To update task id = 11, make a PUT or PATCH request to: http://127.0.0.1:7070/tasks/11


## Endpoint users/search at http://127.0.0.1:7070/users/search
### search (GET/POST)
- To search user with id = 3: http://127.0.0.1:7070/users/search/3 or http://127.0.0.1:7070/users/search?id=3
- To search and paginate users with status = active: http://127.0.0.1:7070/users/search?status=active
- To search and paginate users with status = completed, show = 5 from page 2: http://127.0.0.1:7070/tasks/search?show=5&page=2&status=completed
-  To search and paginate users with status = completed and user_id = 7: http://127.0.0.1:7070/users/search?user_id=7&status=completed

## Endpoint users at http://127.0.0.1:7070/users
### select (GET)
- To show 5 users per page: http://127.0.0.1:7070/users?show=5
- To show 5 users per page begining from page 2: http://127.0.0.1:7070/users?show=5&page=2
- To show user with id = 3: http://127.0.0.1:7070/users/3

### create (POST)
- To create a new user, make a POST request to: http://127.0.0.1:7070/users
- Required fields include email and password

### delete (DELETE)
- To delete an existing user, make a DELETE request to: http://127.0.0.1:7070/users/{id}
- Where {id} is the user id you wish to delete
- To delete user id = 11, make a DELETE request to: http://127.0.0.1:7070/users/11

### update (PUT/PATCH)
- To update an existing user, make a PUT or PATCH request to: http://127.0.0.1:7070/users/{id}
- Where {id} is the user id you wish to update
- To update user id = 11, make a PUT or PATCH request to: http://127.0.0.1:7070/users/11
