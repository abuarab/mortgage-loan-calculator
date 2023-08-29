# Mortgage Loan Calculator

A web application for managing loans and calculating amortization schedules with extra payments.

## Table of Contents

- [Features](#features)
- [Technologies Used](#technologies-used)
- [Installation](#installation)
- [Usage](#usage)
- [Contributing](#contributing)
- [License](#license)

## Features

- Calculate and display amortization schedules for loans.
- Allow users to make extra payments and see updated amortization schedules.
- Store loan and repayment data in a database.
- User-friendly web interface for managing loans and payments.

## Technologies Used

- Laravel: Web application framework used for building the project.
- MySQL: Database management system for storing loan and repayment data.
- PHPUnit: Testing framework used to write and run unit tests.
- Bootstrap: Front-end framework for creating a responsive and visually appealing user interface.

## Installation

1. Clone the repository to your local machine:

   ```bash
   git clone https://github.com/your-username/loan-management-system.git

2. Install project dependencies using Composer:

   ```bash
   composer install

3. Create a .env file by copying the .env.example file:

   ```bash
   cp .env.example .env

4. Configure the .env file with your database settings:

   ```bash
   cp .env.example .env

5. Generate an application key and migrate:

   ```bash
   php artisan key:generate
   php artisan migrate
