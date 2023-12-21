# E-Commerce Platform

Welcome to the E-Commerce Platform, a comprehensive solution for managing users, products, orders, and statistics.

## Overview

The E-Commerce Platform consists of two main components: the E-Commerce Website and the E-Commerce Dashboard. The Website provides a user-friendly interface for customers to browse and purchase products, while the Dashboard offers administrators a powerful tool for managing users, products, and orders.

## E-Commerce Website

Explore a wide range of products and enjoy a seamless shopping experience on our E-Commerce Website.

### Features

- **Product Browsing:** Explore products from different categories.
- **Search Functionality:** Find specific products easily.
- **User Authentication:** Register, log in, and manage your profile.
- **Google Sign-In:** Sign up or log in using Google credentials.
- **Shopping Cart:** Add products to the cart and proceed to checkout.
- **Order History:** View past orders and their status.

#### Real-time Notifications

- Receive notifications when the admin changes the order status.

#### Contact Us (Footer)

- **Email Us:** Use the contact form in the footer to send an email to the owner.

### Getting Started

Follow these steps to set up and run the E-Commerce Website locally.

#### Installation

1. Clone the repository.
2. Install Node.js dependencies:

    ```bash
    npm install
    ```

3. Set up your environment variables.

#### Usage

1. Start the React development server:

    ```bash
    npm start
    ```

2. Open [http://localhost:3000](http://localhost:3000) in your browser.

## E-Commerce Dashboard

The E-Commerce Dashboard provides a user-friendly interface for administrators to handle various aspects of the e-commerce platform.

### Features

#### Registration and Login

- Users can register for an account or log in using traditional credentials.
- Google Sign-In is available for a seamless authentication process.

#### User Roles

- **Admin:** Has full permissions to access all dashboard features.
- **Product Manager:** Can add and edit products.
- **User:** Regular user role with standard functionalities.

#### Dashboard Pages

- **User Management:** Add, edit, and delete users.
- **Category Management:** Create, edit, and delete product categories.
- **Product Management:** Add, edit, and delete products with image upload functionality.
- **Order Management:** View and process orders (confirm, delete, or mark as pending).
- **Statistics:** Track product quantities and sales on a monthly, yearly, and daily basis.
- **Settings:** Manage profile information, including email, phone, etc.

#### Notifications

- Receive notifications for new orders.
- Track unread notifications in the top bar.

#### Filters

- Apply filters on various dashboard pages for enhanced data visibility.

### Dashboard Side

In addition to the core features, the dashboard side includes:

- **Admin Actions:** Add, edit, and delete users, categories, and products.
- **Order Management:** Process orders, change order status, and view order details.
- **Statistics:** Access detailed statistics on product quantities and sales.
- **Settings:** Manage profile information and receive notifications.

### Getting Started

Follow these steps to set up and run the E-Commerce Dashboard locally.

#### Installation

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

#### Usage

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
