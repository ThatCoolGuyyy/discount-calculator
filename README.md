# Discount Calculator
This project is a laravel project that calculates the discount of a customer's order based on various conditions. The solution takes an array of orders and returns a summary of discounts that are applicable to the order. 

The system provides two types of discounts:

- Discount 1: If the customer buys at least 1000 worth of items, they get a 10% discount.
- Discount 2: If the customer buys more than 5 items from category 2, they get a sixth for free.
- Dicount 3: If the customer buys two or more products of category id 1, they get a 20% discount on the cheapest product.

## Installation
- Clone the repository
- Install dependencies by running composer install

## Usage
To use the solution, you can create an array of orders and pass it to the  class. The class will return an array of discounts that are applicable to the orders.

```php  
{
  "id": "3",
  "customer-id": "3",
  "items": [
    {
      "product-id": "A101",
      "quantity": "3",
      "unit-price": "11.75",
      "total": "19.50"
    },
    {
      "product-id": "A102",
      "quantity": "6",
      "unit-price": "16.50",
      "total": "49.50"
    }
  ],
  "total": "69.00"
}
```
- 
