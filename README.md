# Road Luxury E-Commerce Website

Welcome to the repository for Road Luxury, an e-commerce platform developed as a PHP project for school. Road Luxury is designed to revolutionize the way customers shop for cars and puffs, providing a seamless online shopping experience.

## About the Project

Road Luxury aims to provide a user-friendly platform to facilitate the easy purchase of cars and puffs. The project is developed using PHP and integrates various e-commerce functionalities to ensure a smooth and efficient shopping experience. 

### Features

- **Browse Products**: Users can explore a wide range of cars and puffs, with detailed descriptions and pricing information.
- **Shopping Cart**: A convenient shopping cart for users to add and manage their selected products.
- **Checkout Process**: An easy-to-use checkout process that includes payment and shipping options.
- **User Accounts**: Users can create accounts to track their orders, save favorite products, and manage their personal information.

## Getting Started

These instructions will guide you through getting a copy of the project up and running on your local machine for development and testing purposes.

### Prerequisites

To run this project, you'll need to have XAMPP installed on your computer. This will provide you with the necessary PHP environment and MySQL database. If you're not familiar with XAMPP or how to set it up, please refer to the [official XAMPP documentation](https://www.apachefriends.org/index.html).

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/LukasMFR/projet-php-e-commerce.git
   ```

2. Navigate to the project directory:
    ```bash
    cd projet-php-e-commerce
    ```

3. Start XAMPP and ensure both Apache and MySQL services are running.

4. Open phpMyAdmin in your browser (usually accessible by visiting `http://localhost/phpmyadmin`).

5. Create a new database named **shop_db**.

6. Import the **shop_db.sql** file located in the **database** directory of the project:
    - In phpMyAdmin, select your database and click on the "Import" tab.
    - Click on "Choose File" and select the **shop_db.sql** file.
    - Click on "Go" to import the database structure and data.

7. Adjust the project configuration files (if necessary) to connect to your database using the credentials set in phpMyAdmin.

## Usage
After installation, you can use XAMPP to serve the website. Simply place the project in the htdocs directory of your XAMPP installation, and then access it via a web browser by navigating to `http://localhost/projet-php-e-commerce`.

Provide further instructions on how to navigate and use the website's features, including any login credentials for demo accounts if available.

## Contributing
We welcome contributions! If you have suggestions for improvements or bug fixes, please feel free to fork the repository and submit a pull request.

1. Fork the Project
2. Create your Feature Branch (`git checkout -b feature/AmazingFeature`)
3. Commit your Changes (`git commit -m 'Add some AmazingFeature`)
4. Push to the Branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request