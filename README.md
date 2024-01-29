# Project Name

e-commerce project

## Table of Contents

-   [Features](#features)
-   [Prerequisites](#prerequisites)
-   [Installation](#installation)
    -   [Laravel Side](#laravel-side)
    -   [React Side](#react-side)
-   [E-Commerce Dashboard](#e-commerce-dashboard)
    -   [Overview](#overview)
    -   [Features](#dashboard-features)
        -   [Registration and Login](#registration-and-login)
        -   [User Roles](#user-roles)
        -   [Dashboard Pages](#dashboard-pages)
        -   [Notifications](#notifications)
        -   [Filters](#filters)
    -   [Dashboard Side](#dashboard-side)
-   [E-Commerce Website](#e-commerce-website)
    -   [Features](#website-features)
        -   [Product Browsing](#product-browsing)
        -   [Search Functionality](#search-functionality)
        -   [User Authentication](#user-authentication)
        -   [Real-time Notifications](#real-time-notifications)
        -   [Contact Us (Footer)](#contact-us-footer)
-   [Responsive Design](#responsive-design)

## Features

Welcome to the E-Commerce project, a comprehensive solution for managing users, products, orders, and statistics.

## Prerequisites

Make sure you have the following software installed:

-   PHP version 8.1
-   Laravel Framework version 10.10
-   React version 18.2.0

## Installation

### Laravel Side

1. Clone the repository:

    ```bash
    git clone https://github.com/karim-boulad0/e-commerceLaravelSide.git
    ```

2. Install Composer dependencies:

    ```bash
    composer install
    ```

3. Run migrations and seed the database:

    ```bash
    php artisan migrate --seed
    ```

    This will create an admin account with the following credentials:

    - Email: admin@gmail.com
    - Password: admin123$%

4. Generate Passport client for personal access:

    ```bash
    php artisan passport:client --personal
    php artisan passport:keys
    ```

5. Start the Laravel server:
    ```bash
    php artisan serve
    ```

### React Side

1. Clone the repository:

    ```bash
    git clone https://github.com/karim-boulad0/e-commerceReactSide.git
    ```

2. Install Node.js dependencies:

    ```bash
    npm install
    ```

3. Start the React development server:

    ```bash
    npm start
    ```

4. Open [http://localhost:3000/index/homepage](http://localhost:3000/index/homepage) in your browser.

5. Click on the "Login" button in the right side of the top bar.

6. Enter the following login credentials:
    - Email: admin@gmail.com
    - Password: admin123$%

Now you should be able to use the application!

## E-Commerce Dashboard

### Overview

The E-Commerce Dashboard provides a user-friendly interface for administrators to handle various aspects of the e-commerce platform, including user management, product management, order processing, and statistical analysis.

### Dashboard Features

#### Registration and Login

-   Users can register for an account or log in using traditional credentials.
-   Google Sign-In is available for a seamless authentication process.

#### User Roles

-   **Admin:** Has full permissions to access all dashboard features.
-   **Product Manager:** Can add and edit products.
-   **User:** Regular user role with standard functionalities.

#### Dashboard Pages

-   **User Management:** Add, edit, and delete users.
-   **Category Management:** Create, edit, and delete product categories.
-   **Product Management:** Add, edit, and delete products with image upload functionality.
-   **Order Management:** View and process orders (confirm, delete, or mark as pending).
-   **Statistics:** Track product quantities and sales on a monthly, yearly, and daily basis.
-   **Settings:** Manage profile information, including email, phone, etc.

#### Notifications

-   Receive notifications for new orders.
-   Track unread notifications in the top bar.

#### Filters

-   Apply filters on various dashboard pages for enhanced data visibility.

### Dashboard Side

In addition to the core features, the dashboard side includes:

-   **Admin Actions:** Add, edit, and delete users, categories, and products.
-   **Order Management:** Process orders, change order status, and view order details.
-   **Statistics:** Access detailed statistics on product quantities and sales.
-   **Settings:** Manage profile information and receive notifications.

## E-Commerce Website

### Website Features

Explore a wide range of products and enjoy a seamless shopping experience on our E-Commerce Website.

#### Product Browsing

-   Explore products from different categories.

#### Search Functionality

-   Find specific products easily.

#### User Authentication

-   Register, log in, and manage your profile.

#### Real-time Notifications

-   Receive notifications when the admin changes the order status.

#### Contact Us (Footer)

-   **Email Us:** Use the contact form in the footer to send an email to the owner.

## Responsive Design

The E-Commerce project is designed to be responsive on all screen sizes, ensuring a seamless experience for users on various devices. The responsiveness is optimized for the following screen categories:

-   **lg (Large Screens)**
-   **md (Medium Screens)**
-   **sm (Small Screens)**
-   **xs (Extra Small Screens)**
