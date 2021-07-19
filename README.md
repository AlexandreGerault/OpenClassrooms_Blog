
# Blog for OpenClassroom course

This project is a blog made from scratch, thus using my own framework. It goals was to learn basics of PHP and OO paradigm and respecting SOLID principles as needed.


## Installation


Install the project by cloning it onto your system using git

```bash
  git clone https://github.com/AlexandreGerault/OpenClassrooms_Blog.git alexandre_gerault_blog
  cd alexandre_gerault_blog
```

### With Docker

Then you need to import the database. To do this, you first have to check the [Environment Variables](#environment-variables) section so that you can start Docker. When this is done, start Docker and import the database structure:
```bash
  make start
  make db-import
```
If you have the following output, then it means you successfully imported the databse structure, else check your `.env` settings or reset your database:
```
$ make db-import
Executing 001_users.sql script
Executing 002_articles.sql script
Executing 003_comments.sql script
All scripts executed
```

At this point, the project should be available at `http://localhost:${NGINX_PORT}`, referring to your `.env` file for the `${NGINX_PORT}` variable.
You can stop the server with the `make stop` command.
### Without Docker

Firstly, check your `.env` file to fill database information. Then, at the project root directory, run the migration with
```bash
php database/run.php
```
If you have the following output, then it means you successfully imported the databse structure, else check your `.env` settings, or reset your database, or check your database is actually started:
```
$ php database/run.php
Executing 001_users.sql script
Executing 002_articles.sql script
Executing 003_comments.sql script
All scripts executed
```

Once you imported the database, you should be able to start the project using the internal server from PHP:
```bash
php -S localhost:${HTTP_PORT} -t public/
```
Where `${HTTP_PORT}` is an available port on your local device.
## Environment Variables

To run this project, you first need to copy `.env.example` to `.env`. Then you can customize variables as needed to run the environment.
  
