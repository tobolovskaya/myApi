# API — Project on Laravel 11

This is a sample project for the **API** workshop, where we explore the fundamentals of REST API development. The project includes models for **User**, **Product**, and **Order**, which are used to practice creating and using CRUD endpoints (Create, Read, Update, Delete).

## Requirements

- **PHP** version **8.2** or higher  
- **Composer** (installed globally or locally)  
- Laravel 11 project based on this repository  

## Installation

1. **Clone** or **extract** the project into your desired directory:

   ```bash
   git clone <repository-url>
   ```
2. Install the project dependencies:

    ```bash
    composer install
    ```
3.	Run database migrations:

    ```bash
    php artisan migrate
    ```
## Running the Application

After installing all dependencies and configuring the environment, launch the built-in server with:

```bash
php artisan serve
```
Or manually with:

```bash
php -S 127.0.0.1:8010 -t public
```

By default, the application will be available at http://127.0.0.1:8000.

## Project Structure
	•	app/Models — contains the Product, Order, and User models.
	•	routes/api.php — where you can find or define your API routes.
	•	app/Http/Controllers/Api — contains controllers that handle CRUD logic.


Happy coding! 🚀
