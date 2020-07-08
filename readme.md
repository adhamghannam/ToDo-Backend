This codebase was created to as a simple backend for a ToDo app using PHP Lumen framework and MySQL.
Its build as a fully functional REST APIs, including CRUD operations, authentication, routing, and more.

----------

# Getting started

## Installation

Please check the official Lumen installation guide for server requirements before you start. [Official Documentation](https://lumen.laravel.com/docs/5.5/installation)


Clone the repository

    git clone https://github.com/adhamghannam/ToDo-Backend.git

Switch to the repo folder

    cd ToDo-Backend


Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

create a new Database and Import the sql ToDo.sql located in the main directory,

Start the local development server

    php -S localhost:8000 -t public

You can now access the server at http://localhost:8000

The database will have some demo data in each table

----------

# Testing API

Run the Lumen development server

    php -S localhost:8000 -t public

The api can now be accessed at

    http://localhost:8000/

----------

# Authentication

This applications uses the `Authorization` header with Bearer `token`.

APIs that should not be authenticated by the `token` are:

 * Login
    - Link: http://localhost:8000/login
    - Type: get
    - Parameters:
      - email (required, email format)
      - password (required)
    - Output: success with "Token" or failure message

 * Registration
    - Link: http://localhost:8000/register
    - Type: post
    - Parameters:
      - firstname (required)
      - lastname (required)
      - gender (required, integer, 0 or 1)
      - email (required, email format)
      - password (required)
      - mobile (required)
      - date_of_birth (required, date before today, date format: Y-m-d)
    - Output: success or failure message

APIs that should be authenticated by the `token` are:

* Logout

* Add Item
   - Link: http://localhost:8000/item
   - Type: post
   - Parameters:
     - name (required)
     - description (optional)
     - datetime (required, date after today, date format: Y-m-d H:i)
     - category_id (required, integer, valid category id)
   - Output: success or failure message

* Update Item
   - Link: http://localhost:8000/item/{id}
   - Type: put
   - Parameters:
     - name (optional)
     - description (optional)
     - datetime (optional, date after today, date format: Y-m-d H:i)
     - category_id (optional, integer, valid category id)
   - Output: success or failure message

* Delete Item
   - Link: http://localhost:8000/item/{id}
   - Type: delete
   - Parameters: none
   - Output: success or failure message

* Get Item
   - Link: http://localhost:8000/item/{id}
   - Type: get
   - Parameters: none
   - Output: one todo list item details as a Json format, or failure

* Get Items
   - Link: http://localhost:8000/items
   - Type: get
   - Parameters:
    - category_id (optional, integer, valid category id)
    - status_id (optional, integer, valid category id)
   - Output: all todo list items as a Json format filtered by the provided Parameters
    (category_id, status_id, both, or none), or failure
