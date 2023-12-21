# E-Commerce Dashboard

Welcome to the E-Commerce Dashboard, a comprehensive solution for managing users, products, orders, and statistics.

## Overview

The E-Commerce Dashboard provides a user-friendly interface for administrators to handle various aspects of the e-commerce platform, including user management, product management, order processing, and statistical analysis.

## Features

### Registration and Login

- Users can register for an account or log in using traditional credentials.
- Google Sign-In is available for a seamless authentication process.

### User Roles

- **Admin:** Has full permissions to access all dashboard features.
- **Product Manager:** Can add and edit products.
- **User:** Regular user role with standard functionalities.

### Dashboard Pages

- **User Management:** Add, edit, and delete users.
- **Category Management:** Create, edit, and delete product categories.
- **Product Management:** Add, edit, and delete products with image upload functionality.
- **Order Management:** View and process orders (confirm, delete, or mark as pending).
- **Statistics:** Track product quantities and sales on a monthly, yearly, and daily basis.
- **Settings:** Manage profile information, including email, phone, etc.

### Notifications

- Receive notifications for new orders.
- Track unread notifications in the top bar.

### Filters

- Apply filters on various dashboard pages for enhanced data visibility.

## Dashboard Side

In addition to the core features, the dashboard side includes:

- **Admin Actions:** Add, edit, and delete users, categories, and products.
- **Order Management:** Process orders, change order status, and view order details.
- **Statistics:** Access detailed statistics on product quantities and sales.
- **Settings:** Manage profile information and receive notifications.

## Getting Started

Follow these steps to set up and run the E-Commerce Dashboard locally.

### Installation

1. Clone the repository.
2. Install Composer dependencies:

    ```bash
    composer install
    ```

3. Install Node.js dependencies:

    ```bash
    npm install
    ```

4. Set up your database and configure your environment variables.

5. Run migrations:

    ```bash
    php artisan migrate --seed
    ```

### Usage

1. Start the Laravel server:

    ```bash
    php artisan serve
    ```

2. Start the React development server:

    ```bash
    npm start
    ```

3. Open [http://localhost:3000](http://localhost:3000) in your browser.

## Contributing

Contributions are welcome! Please follow our [Contribution Guidelines](CONTRIBUTING.md).

## License

This project is licensed under the [Your License] - see the [LICENSE.md](LICENSE.md) file for details.

## Acknowledgments

Thank you to all contributors and third-party libraries that made this project possible.

