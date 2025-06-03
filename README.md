# Project developed for the Integrative Project (PI) of the second semester.

This project is an API built using **Laravel Breeze and SQLite as database.**

## Table of Contents

- [Developer Team](#developer-team)
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
- [API Endpoints](#api-endpoints)
- [API Testing](#api-testing)
- [Authentication](#authentication)
- [Database](#database)
- [Contributing](#contributing)


## Developer Team

- [Luis Bernardo Pessanha Batista](https://github.com/lbpb293)  
- [Luiz Gustavo Trindade Neves  ](https://github.com/luizinbrzado)
- [Murilo Poltronieri  ](https://github.com/murilopbc)
- [Pedro Henrique Tamotsu Tozaki ](https://github.com/tamotsutozaki) 
- [Rafael Tadeu Praça ](https://github.com/RafaTPz) 
- [Weslley de Andrade Rosário  ](https://github.com/w-rosario)


## Installation

1. Clone the repository:

```bash
https://github.com/second-integrated-project/pi-segundo-semestre.git
```

2. Install PHP dependencies:

```bash
composer install
```

3. Install Vite dependencies:

```bash
npm i
```

4. Create .env file:

```bash
cp .env.example .env
```

5. Generate API key:

```bash
php artisan key:generate
```

6. Configure .env file to connect with database:

```env
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
DB_USERNAME=
DB_PASSWORD=
```

7. Make migrations on database:

```bash
php artisan migrate
```

8. To run Vite:

```bash
npm run dev
```

9. To run PHP:

```bash
php artisan serve
```

## Usage

1. The API will be accessible at http://localhost:8000
2. You must have installed [Composer](https://getcomposer.org/download/) and [PHP](https://windows.php.net/download/) to run this application!   


## API Testing

I recommend you to use [Postman](https://www.postman.com/downloads/) or [Insomnia](https://insomnia.rest/download)  to project, build, test and collaborate your application.

## Authentication

The API uses Laravel Breeze for authentication control. The following roles are available:

```
USER -> Standard user role for logged-in users.
ADMIN -> Admin role for managing partners.
```
To access protected endpoints as an ADMIN user, provide the appropriate authentication credentials in the request header.

## Database

The project utilizes [SQLite](https://www.sqlite.org/index.html) as the database.

## Contributing

Contributions are welcome! If you find any issues or have suggestions for improvements, please open an issue or submit a pull request to the repository.

When contributing to this project, please follow the existing code style, [commit conventions](https://github.com/iuricode/padroes-de-commits), and submit your changes in a separate branch.