# Store refactor

This project was made for the course of Software quality assurance at Instituto Tecnológico de Costa Rica, by using Laravel as framework, the original repo was deleted, I did not own it,
the idea with this is to take it as a base, refactor it, delete some features that I'm finding unnecesary, use framework features that at the point were unknown and create an API to be used as a backend for the mobile version. The git for the mobile version will be posted when started.


## Contributors
It began as a group project, not all its development was made by myself

- [Josué Vargas](https://github.com/JoVarHdez)


## Entities

Entities needed for requests and responses

### Cart
Total: total of all products price
Cart: list with all products in cart
```
{
    "total" : number,
    "cart" : list<Product>
}
```

### Category
id: Category id
Name: name of category
Description: description of category
Enable: Indicates if category is enabled, products within this category are not returned if false
```
{
    "id" : int
    "name" : string,
    "description" : string,
    "enable" : boolean
}
```

### Comment
id: Comment id
Comment: comment (text)
Calification: A calification of product, must be between 1 and 5
product_id: id of product the comment belongs to
user_id: id of user that made the comment
```
{
    "id" : int
    "comment" : string,
    "calification" : 1 <= int <= 5,
    "product_id" : int,
    "user_id" : int
}
```

### Orders
id: Order id
Total: total of all products price
date: date when order was generated
address: id of product the comment belongs to
user_id: id of user that made the comment
```
[
    {
        "id" : int
        "total" : string,
        "date" : 1 <= int <= 5,
        "address" : int,
        "user_id" : int
    }
]
```

### Order
name: name of product
image: path of file
price: price of product
```
[
    {
        "name" : string,
        "image" : string,
        "price" : number
    }
]
```

### Product
id: Product id
name: name of product
description: product description
image: path of file
price: price of product
stock: product stock
available: indicates if product is available
califications: amount of comments/califications the product 
category_id: product category
```
{
    "id" : int,
    "name" : string,
    "description" : string,
    "image" : string,
    "price" : number,
    "stock" : int,
    "available" : boolean,
    "califications" : int,
    "average" : float,
    "category_id" : int
}
```

### Reply
id: reply id
reply: comment (text)
calification_id: comment of reference
user_id: id of user that made the comment
```
{
    "id" : int
    "reply" : string,
    "calification_id" : int,
    "user_id" : int
}
```

### User

id: user id
name: user name
email: user email
```
{
    "id" : int
    "name" : string,
    "email" : string
}
```

## Routes
| Action | URL | BODY | RESPONSE |
| POST | api/login | email, password | API token |
| POST | api/logout | | true |
| POST | api/register | userName, userEmail, password | true |
| GET | api/products |  | list of Products |
| GET | api/products/category/category_id | | list of Product by the category|
| POST | api/products/search | expression, category | list of Product that matches expression and category |
| GET | api/products/product_id | | Product details and comments |
| POST | api/login | email, password | API token |