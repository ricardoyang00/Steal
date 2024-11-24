# EAP: Architecture Specification and Prototype

**Project Vision**

**STEAL!** is an online marketplace focused on selling Content Distribution Keys (CDKs). It offers a secure, user-friendly platform for gamers seeking affordable game keys, aiming to become the top destination for accessible, high-quality digital gaming.

> **"SO AFFORDABLE IT'S LIKE STEALING!"** 

----

## A7: Web Resources Specification

This artifact documents the architecture of the web application to be developed, indicating the catalog of resources, the properties of each resource, and the format of JSON responses. This page includes the following operations over data: create, read, update, and delete.

### 1. Overview

| Module | Description |
|--|--|
| M01: Authentication and Profile | Web resources for user authentication and profile management, including handling user information and roles. |
| M02: Products Browse and Details | Web resources for searching, filtering, sorting, and listing available products, as well as viewing product details. |
| M03: Shopping Cart | Web resources for adding products to the shopping cart and managing the cart. |
| M04: Checkout | 	Web resources for proceeding to checkout, including navigation of purchase history. |
| M05: User Administration | Web resources for administrative functions, including managing users, products, and maintaining the shop's functionality. |
| M06: Static Pages | Web resources for static content and pages such as About, Contact, and FAQs. |

### 2. Permissions

| Role | Description | Permissions |
| -- | -- | -- |
| **PUB** | Public | Group of users without privileges, namely "Anonymous users". Can browse public content. |
| **USR** | User | General authenticated users. Can update their profiles. |
| **BYR** | Buyer |  Authenticated users who can purchase products. |
| **SLR** | Seller | Authenticated users who can list products for sale but cannot purchase products. |
| **ADM** | Administrator | Group of administrators with full access to manage users, products, and site settings. |


### 3. OpenAPI Specification

> OpenAPI specification in YAML format to describe the vertical prototype's web resources.

> Link to the `a7_openapi.yaml` file in the group's repository.


```yaml
openapi: 3.0.0

...
```

---


## A8: Vertical prototype

This artifact contains the implementation of most of the high priority user stories of our web application and all mandatory features for its vertical prototype (features marked with an * in the common and theme requirements documents).
Our implementation is based on the LBAW Framework and includes work both on the client and server side of the application, focusing both on user interface and server data access. By implementing all the features described in this section, our protoype has a functional implementation of all CRUD operations (Create, Read, Update, Delete).

### 1. Implemented Features

#### 1.1. Implemented User Stories

Identification of the user stories that were implemented in the prototype.  

| User Story reference | Name      | Priority    | Responsible        | Description                                           |
| -------------------- | --------- | ----------- | ------------------ | ----------------------------------------------------- |
| US01                 | Browse Marketplace | High | Ricardo Yang | As an Anonymous User, I want to browse the marketplace, view and filter the product list and categories, so that I can explore available CDKs. |
| US02                 | View Product Details | High | Ricardo Yang | As an Anonymous User, I want to view detailed information about a game, including reviews, so that I can decide if I want to purchase it. |
| US03                 | Register Account | High | Bruno Huang | As an Anonymous User, I want to register an account, so that I can access additional features. |
| US04                 | Sign In Account  | High | Bruno Huang | As an Anonymous User, I want to sign in to my account, so that I can have access additional features. |
| US05                 | Add to Shopping Cart | High | Daniel Basílio | As an Anonymous User, I want to add games to a shopping cart, so that I can purchase multiple items at once. |
| US06                 | Manage Shopping Cart | High | Daniel Basílio | As an Anonymous User, I want to manage my shopping cart, so that I can update quantities or remove items before purchasing. |
| US07                 | Full Text Search | High | Ricardo Yang | As an Anonymous User, I want to perform full-text searches across the game catalog, so that I can quickly find games based on keywords. |
| US08                 | Search Games by Genre/Platform | High | Ricardo Yang | As an Anonymous User, I want to search for games by genre, platform, price, language and rating, so that I can quickly find the games I am interested in. |
| US09                 | Access Static Pages | Medium | Ricardo Yang | As an Anonymous User, I want to view static pages (About Us, Contact Us, FAQs), so that I can understand the platform’s purpose and policies. |
| US10                 | Delete Own Account | High | Bruno Huang | As an Authenticated User, I want the option to delete my own account, so that I can control my personal data on the platform. |
| US11                 | Edit Profile | High | Bruno Huang | As an Authenticated User, I want to be able to edit my profile, so that I can personalize my account. |
| US12                 | Log Out | High | Bruno Huang | As an Authenticated User, I want to log out of my account, so that my session is securely terminated and my account is protected. |
| US13                 | View Profile | High | Bruno Huang | As an Authenticated User, I want to view my profile information, so that I can see my account details and ensure they are correct. |
| US14                 | Update Profile Information | High | Bruno Huang | As an Authenticated User, I want to update my profile information, so that my account details are up to date. |
| US15                 | Change Password| High | Bruno Huang | As an Authenticated User, I want to change my password, so that I can maintain the security of my account. |
| US18                 | Checkout Items | High | Francisco Magalhães | As a Buyer, I want to complete the checkout process for items in my cart or individual items, so that I can finalize my purchases efficiently. |
| US22                 | Track Purchase History | Medium | Francisco Magalhães | As a Buyer, I want to track my purchase history, so that I can review my past orders. |
| US26                 | Cancel Order | Medium | Francisco Magalhães | As a Buyer, I want to cancel my order, so that I can manage my purchases effectively if I change my mind. |
| US29                 | Multiple Payment Options | Low | Francisco Magalhães | As a Buyer, I want to complete my purchase using multiple payment methods as by PayPal, MBWay or credit card, so that I can choose the most convenient method for me. |
| US39                 | Administer User Accounts (Search, View, Edit, Create) | High | Bruno Huang | As an Administrator, I want to manage user accounts by searching for, viewing, editing, and creating user profiles, so that I can ensure that user information is accurate and up to date on the platform. |

#### 1.2. Implemented Web Resources

Module M01: Authentication and User Profile  

| Web Resource Reference | URL                            |
| ---------------------- | ------------------------------ |
| R101: Login Form | GET /login |
| R102: Login Action | POST /login |
| R103: Logout Action | POST /logout |
| R104: Register Form | GET /register |
| R105: Register Action | POST /register |
| R106: View Profile | GET /profile |
| R107: Edit Profile | PUT /profile/edit |
| R108: Change Password | POST /profile |


M02: Products Browse and Details

| Web Resource Reference | URL                            |
| ---------------------- | ------------------------------ |
| R201: Game Explore and Search | GET /explore |
| R202: View Game Details | GET /game/{id} |


Module M03: Shopping Cart

| Web Resource Reference | URL                            |
| ---------------------- | ------------------------------ |
| R301: View Shopping Cart | GET /cart |
| R302: Add Product To Shopping Cart | POST /cart/add_product |
| R303: Increase Quantity in Shopping Cart | POST /cart/increase_quantity |
| R304: Decrease Quantity in Shopping Cart | POST /cart/decrease_quantity |
| R305: Remove Product From Shopping Cart | POST /cart/remove_product |


Module M04: Checkout

| Web Resource Reference | URL                            |
| ---------------------- | ------------------------------ |
| R0401: Proceed to Checkout | POST /checkout |
| R0402: Get Payment Methods | GET /checkout/payment |
| R0403: Choose Payment Method | POST /checkout/payment |
| R0404: Get Receipt | GET /checkout/receipt |
| R0405: View Purchase History | GET /user/{id}/order-history |


Module M05: User Administration

| Web Resource Reference | URL                            |
| ---------------------- | ------------------------------ |
| R501: Search Users | GET /admin/users/search |
| R503: List All Users | GET /admin/all-users |
| R502: View User Profile | GET /admin/users/{id} |
| R504: Change User's Username | POST /admin/users/{id}/change-username |
| R505: Change User's Name | POST /admin/users/{id}/change-name |
| R506: Change User's Coins | POST /admin/users/{id}/change-coins |


Module M06: Static Pages

| Web Resource Reference | URL                            |
| ---------------------- | ------------------------------ |
| R601: Contact | GET /contact |
| R602: FAQ | GET /faqs |
| R603: About | GET /about |


### 2. Prototype

> Command to start the Docker image from the group's Container Registry.
> User credentials necessary to test all features.
> Link to the source code in the group's Git repository.


---


## Revision history

Changes made to the first submission:
1. Item 1
1. ..

***
GROUP2435, 24/11/2024
 
* Bruno Huang, up202207517@up.pt
* Daniel Basílio, up201806838@up.pt
* Francisco Magalhães, up202007945@up.pt
* Ricardo Yang, up202208465@up.pt (Editor)
