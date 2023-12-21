# Project Name

Brief description of your project.

## Requirements

Make sure you have the following software installed:

- PHP version 8.1
- Laravel Framework version 10.10
- React version 18.2.0

## Laravel Side

1. Install Composer dependencies:

    ```bash
    composer install
    ```

2. Run migrations and seed the database:

    ```bash
    php artisan migrate --seed
    ```

    This will create an admin account with the following credentials:
    - Email: admin@gmail.com
    - Password: admin123$%

3. Generate Passport client for personal access:

    ```bash
    php artisan passport:client --personal
    ```

4. Start the Laravel server:

    ```bash
    php artisan serve
    ```

## React Side

1. Install Node.js dependencies:

    ```bash
    npm install
    ```

2. Start the React development server:

    ```bash
    npm start
    ```

3. Open [http://localhost:3000/index/homepage](http://localhost:3000/index/homepage) in your browser.

4. Click on the "Login" button in the right side of the top bar.

5. Enter the following login credentials:
    - Email: admin@gmail.com
    - Password: admin123$%

Now you should be able to use the application!

