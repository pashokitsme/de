# DevContainer for Laravel 10 Development

This directory contains the configuration for a Visual Studio Code DevContainer setup for Laravel 10 development with PHP 8.2 and MySQL 8.0.

## Components

- **PHP 8.2** with required extensions for Laravel
- **MySQL 8.0** as the database
- **Composer** for PHP dependencies
- **Node.js and NPM** for frontend assets

## Usage

1. Install [Docker](https://www.docker.com/products/docker-desktop) and [Visual Studio Code](https://code.visualstudio.com/).
2. Install the [Remote - Containers](https://marketplace.visualstudio.com/items?itemName=ms-vscode-remote.remote-containers) extension in VS Code.
3. Open this project in VS Code.
4. When prompted, click "Reopen in Container" or use the command palette (F1) and select "Remote-Containers: Reopen in Container".
5. Wait for the container to build and start (this may take a few minutes on first run).

## Database Connection

The MySQL database is configured with the following credentials:

- **Host**: db (or localhost on port 3306 from outside the container)
- **Database**: laravel
- **Username**: laravel
- **Password**: laravel_password
- **Root Password**: root_password

## Running Laravel

Once the container is started:

1. The container automatically runs `composer install` and `php artisan key:generate` on first start.
2. To start the Laravel development server: `php artisan serve --host=0.0.0.0`
3. Access your application at http://localhost:8000

## Customization

You can modify the container configuration by editing:

- `devcontainer.json` - VS Code configuration and extensions
- `docker-compose.yml` - Service configuration
- `Dockerfile` - PHP environment setup 
