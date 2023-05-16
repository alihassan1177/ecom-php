# Introduction

This is an Ecommerce Application built using PHP and MySQL.

## Features

- User Registration and Login: Allows users to create an account and log in to the application.
- Product Catalog: Displays a catalog of available products for users to browse and purchase.
- Shopping Cart: Enables users to add products to a cart and proceed to checkout.
- Payment Integration: Integrates with a payment gateway for secure and convenient online transactions.
- Order Management: Provides order history and order tracking functionality for users.
- Admin Panel: Includes an administrative panel for managing products, orders, and user accounts.

## Requirements

To run this application locally, ensure that you have the following software installed:

- PHP (version 7 or above)
- MySQL (version 5.6 or above)
- Web server (such as Apache or Nginx)

## Installation

1. Clone the repository:

```
git clone https://github.com/your-username/ecommerce-app.git
```

2. Change into the project directory:

```
cd ecommerce-app
```

3. Create a new MySQL database for the application.

4. Rename the `.env.example` file to `.env` and update the database configuration settings in the `.env` file:

```
DB_USER="your_database_username"
DB_PASSWORD="your_database_password"
DB_HOST="your_database_host"
DB_NAME="your_database_name"
DB_PORT="your_database_port"
SITE_NAME="your_sitename"
```

5. Use the SQL file to import Database:

```
ecom_php.sql
```

6. Start the local development server in public directory:

```
php -S localhost:8000
```

7. Open your web browser and navigate to `http://localhost:8000` to access the application.

## Usage

- Register a new user account or log in with existing credentials.
- Browse the product catalog and select items to add to the cart.
- Proceed to the checkout to enter shipping and payment details.
- Complete the purchase by confirming the order.
- Use the admin panel to manage products, orders, and user accounts.

## Contributing

Contributions to this project are welcome. If you find any issues or have suggestions for improvements, please open an issue or submit a pull request.

## License

This project is licensed under the [MIT License](LICENSE).