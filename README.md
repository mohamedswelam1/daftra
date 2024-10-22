# E-Commerce

a simplified RESTful API for managing `Products` and `Orders` in a small
e-commerce system

## Installation
Instructions for setting up your project locally.

## Prerequisites

- PHP >= 8.x
- Composer
- MySQL

Use the package manager [Composer](https://getcomposer.org/) to install project dependencies.
# Steps to Install
- Clone the Repository: Clone the repository to your local machine using Git
```bash
git clone https://github.com/mohamedswelam1/daftra.git
```

```bash
composer install
```

```bash
cp .env.example .env
```
```bash
php artisan key:generate
```
```bash
php artisan migrate --seed
```
```bash
php artisan serve
```


## API Documentation

### Products

- **GET /api/products**
    - **Description:** Retrieve a list of products with pagination.
    - **Response:** JSON array of products.

- **POST /api/products**
    - **Description:** Create a new product.
    - **Request Body:**
      ```json
      {
        "name": "Product Name",
        "price": 100,
        "description":"description info",
        "quantity": 50
      }
      ```
    - **Response:** 
       ```json
        {
          "status": "success",
          "message": "Product created successfully",
          "data": {
          "id": 54,
          "name": "Product Name",
          "price": 100,
          "quantity": 50
          "description": "description info",
          "created_at": "2024-10-22T06:30:42.000000Z",
          "updated_at": "2024-10-22T06:30:42.000000Z"
          }
       }
### Orders

- **POST /api/orders**
    - **Description:** Place a new order.
    - **Request Body:**
      ```json
      {
        "total_amount":100 ,
        "products": [
          {
            "id": 1,
            "quantity": 2
          }
        ]
      }
    - **Response:** 
      ```json
      {
        "status": "success",
        "message": "Order placed successfully!",
        "data": {
                  "id": 2,
                   "user_id": 4,
                   "total_amount": 200,
                   "status": "pending",
                   "created_at": "2024-10-22T06:38:34.000000Z",
                   "updated_at": "2024-10-22T06:38:34.000000Z"
                 }
      }
- **GET /api/orders/{id}**
    - **Description:** Retrieve order details.
    - **Response:** JSON object of the order.

## Testing

- To run the tests, use the command:
```bash
php artisan test
```