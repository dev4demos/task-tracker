# kt-team (10-06-2020)

# RU - русский

# Установка
Этот пакет использует Composer для управления своими зависимостями. Убедитесь, что на вашем компьютере установлен Composer.
Затем выполните следующие команды в своем терминале:
1) Для этого пакета требуется структура Laravel. Чтобы установить laravel, выполните следующую команду
- composer create-project --prefer-dist laravel / laravel задача "6.2. *"
2) Измените ваш каталог на вновь созданный проект. На окнах команда:
- Задача CD
2) После завершения установки laravel выполните следующую команду для установки этого пакета.
- композитору требуется drnkwati / task-tracker
3) изменить конфигурацию базы данных для вашего приложения в файле конфигурации .env
- Вы можете использовать любую реляционную базу данных, поддерживаемую фреймворком laravel. Просто установите соединение с базой данных и запустите миграцию.
- Для вашего удобства этот пакет поставляется с демонстрационной базой данных sqlite с начальными данными.
- Чтобы использовать эту демонстрационную базу данных, обновите соединение конфигурации базы данных .env: DB_CONNECTION = taskTrackerDemo
4) Вы можете использовать веб-сервер, такой как Apache или Nginx, для обслуживания своих приложений. Использовать встроенный сервер разработки PHP. В Windows запустите следующую команду:
- php artisan serve --port = 7070
5) Откройте веб-браузер по адресу: http://127.0.0.1:7070/tasks

# Возможные конечные точки API включают в себя:
- http://127.0.0.1:7070/tasks/search
- http://127.0.0.1:7070/tasks
- http://127.0.0.1:7070/users/search
- http://127.0.0.1:7070/users

- API можно получить через такой инструмент, как почтальон. Для простых запросов HTTP GET вы можете использовать веб-браузер.

# Примеры использования:
## В следующих запросах предполагается, что вы используете демонстрационную базу данных.
* Когда вы делаете PUT, PATCH или DELETE, вам нужно добавить скрытое поле \_method в форму

## Задачи конечных точек / поиск по адресу http://127.0.0.1:7070/tasks/search
### поиск (GET / POST)
- Для поиска задачи с идентификатором = 3: http://127.0.0.1:7070/tasks/search/3 или http://127.0.0.1:7070/tasks/search?id=3.
- Для поиска и разбивки на страницы задач с состоянием = active: http://127.0.0.1:7070/tasks/search?status=active
- Чтобы выполнить поиск и разбить на страницы задачи с состоянием = выполнено, отобразите = 5 на странице 2: http://127.0.0.1:7070/tasks/search?show=5&page=2&status=completed
- Для поиска и разбиения на страницы задач с состоянием = выполнено и user_id = 7: http://127.0.0.1:7070/tasks/search?user_id=7&status=completed

## Задачи конечных точек на http://127.0.0.1:7070/tasks
### выбрать (GET)
- Показать 5 задач на странице: http://127.0.0.1:7070/tasks?show=5
- Показать 5 задач на страницу, начиная со страницы 2: http://127.0.0.1:7070/tasks?show=5&page=2.
- Показать задачу с id = 3: http://127.0.0.1:7070/tasks/3

### создать (POST)
- Чтобы создать новую задачу, сделайте запрос POST по адресу: http://127.0.0.1:7070/tasks
- Обязательные поля включают user_id и title

### удалить (УДАЛИТЬ)
- Чтобы удалить существующую задачу, сделайте запрос DELETE по адресу: http://127.0.0.1:7070/tasks/ndomid}
- где {id} - идентификатор задачи, которую вы хотите удалить
- Чтобы удалить идентификатор задачи = 11, сделайте запрос DELETE по адресу: http://127.0.0.1:7070/tasks/11

### обновление (PUT / PATCH)
- Чтобы обновить существующую задачу, сделайте запрос PUT или PATCH по адресу: http://127.0.0.1:7070/tasks/ndomid}
- где {id} - это идентификатор задачи, которую вы хотите обновить
- Чтобы обновить идентификатор задачи = 11, сделайте запрос PUT или PATCH по адресу: http://127.0.0.1:7070/tasks/11


## Пользователи конечной точки / поиск по адресу http://127.0.0.1:7070/users/search
### поиск (GET / POST)
- Для поиска пользователя с ID = 3: http://127.0.0.1:7070/users/search/3 или http://127.0.0.1:7070/users/search?id=3.
- Для поиска и разбивки на страницы пользователей со статусом = активный: http://127.0.0.1:7070/users/search?status=active
- Для поиска и разбивки на страницы пользователей с состоянием = выполнено, отобразите = 5 на странице 2: http://127.0.0.1:7070/tasks/search?show=5&page=2&status=completed
- Для поиска и разбивки на страницы пользователей со статусом = выполнено и user_id = 7: http://127.0.0.1:7070/users/search?user_id=7&status=completed

## Пользователи конечной точки на http://127.0.0.1:7070/users
### выбрать (GET)
- Показать 5 пользователей на странице: http://127.0.0.1:7070/users?show=5
- Чтобы показать 5 пользователей на страницу, начиная со страницы 2: http://127.0.0.1:7070/users?show=5&page=2
- показать пользователя с id = 3: http://127.0.0.1:7070/users/3

### создать (POST)
- Чтобы создать нового пользователя, сделайте запрос POST по адресу: http://127.0.0.1:7070/users
- обязательные поля включают адрес электронной почты и пароль

### удалить (УДАЛИТЬ)
- Чтобы удалить существующего пользователя, сделайте запрос DELETE по адресу: http://127.0.0.1:7070/users/ndomid}
- где {id} - идентификатор пользователя, которого вы хотите удалить
- Чтобы удалить идентификатор пользователя = 11, сделайте запрос DELETE по адресу: http://127.0.0.1:7070/users/11

### обновление (PUT / PATCH)
- Чтобы обновить существующего пользователя, сделайте запрос PUT или PATCH по адресу: http://127.0.0.1:7070/users/ndomid}
- где {id} - это идентификатор пользователя, который вы хотите обновить
- Чтобы обновить идентификатор пользователя = 11, сделайте запрос PUT или PATCH по адресу: http://127.0.0.1:7070/users/11

# EN - english

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

- The api can be accessed through a tool such as postman. For simple http GET requests, you can use a web browser.

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
