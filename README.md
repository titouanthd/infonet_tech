# Infonet.tech

## introduction

Welcome to Infonet.tech, this app creates a Star Wars characters and movies database using an existing API. The app downloads 30 characters and all the movies from the API and fills the database with that information. The app includes a command to download the required information. The database includes three tables: characters, movies, and movie characters. The app displays the list of all characters and allows for character search by name. When clicking on a character, the user is redirected to a form to edit character data and upload an image. The app also allows for character deletion. Additionally, there is a page that lists all the movies in the database and allows users to see the list of characters in each movie with uploaded images.

## installation

### requirements

Before you begin with the installation process, make sure that your system meets the following requirements:

- PHP 8.0 or later
- Composer
- Node.js (version 14 or later) and npm
- Symfony CLI
- SQLite

### Clone the repository

Clone the Infonet.tech GitHub repository to your local machine using the following command:

```
git clone https://github.com/titouanthd/infonet.tech.git
```

### Create DB

To create a new database for Infonet.tech Symfony 6 application, use the Doctrine command provided by Symfony CLI as follows:

```
symfony console doctrine:database:create
```

This command will create a new database with the name specified in the DATABASE_URL environment variable in the .env file. If you need to change the database name, update the DATABASE_URL accordingly.

Note that you will need to have SQLite installed on your system to be able to create the database.

### Run migrations

Run the database migration to create the required database tables using the following command:

```
symfony console doctrine:migrations:migrate
```

### Load fixtures
You can create a fake user using the following command:

```
php bin/console doctrine:fixtures:load
```

### Load data

You can load data from api using the following command:

```
php bin/console starwars:import
```

### install dependencies

Install the project dependencies using the following commands:

```
composer install
npm install
```

### compil assets

Compile the frontend assets using the following command:

```
npm run dev
```

### start serve

Start the Symfony development server using the following command:

```
symfony serve
```

### Accessing the Backend

To access the backend of the Infonet.tech Symfony 6 application, follow these steps:

1. Open your web browser and navigate to http://localhost:8000/login.
2. Enter the following email and password to log in:

- Email: `admin@infonet.tech`
- Password: `0000`

After logging in, you will be directed to the admin dashboard

## Conclusion

Congratulations, you have successfully installed the Infonet.tech application.
