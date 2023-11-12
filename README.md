<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# How to set up the project locally
**Clone the Repository**

   Open your terminal and run the following command:

```bash
   git clone https://github.com/matic031/naloga-laravel.git
  ```
**Go to the project directory and build with docker:**

```bash
   docker compose up --build
  ```



# Run the PHPUnit tests
- **Run command:** `docker exec -it laravel-app vendor/bin/phpunit tests/Unit/ProductControllerTest.php`

# Test the API

### List All Products
- **Method:** GET
- **URL:** `http://localhost/api/products`
- **Description:** Retrieves a list of all products.

### Get a Specific Product
- **Method:** GET
- **URL:** `http://localhost/api/products/{id}`
- **Description:** Retrieves a specific product by its ID. Replace `{id}` with the actual product ID.

### Create a New Product
- **Method:** POST
- **URL:** `http://localhost/api/products`
- **Description:** Creates a new product.
- **Body (JSON):**
    ```json
    {
      "title": "Product Title",
      "description": "Product Description",
      "price": 100.00
    }
    ```
- **Note:** Replace the values with the product details you want to add.

### Update an Existing Product
- **Method:** PUT or PATCH
- **URL:** `http://localhost/api/products/{id}`
- **Description:** Updates an existing product. Replace `{id}` with the ID of the product you want to update.
- **Body (JSON):**
    ```json
    {
      "title": "New Product Title",
      "description": "New Product Description",
      "price": 150.00
    }
    ```
- **Note:** All fields are optional for updates. Replace the values with the new details for the product.

### Delete a Product
- **Method:** DELETE
- **URL:** `http://localhost/api/products/{id}`
- **Description:** Deletes a specific product. Replace `{id}` with the ID of the product you want to delete.
