# EAP: Architecture Specification and Prototype

**Project Vision**

**STEAL!** is an online marketplace focused on selling Content Distribution Keys (CDKs). It offers a secure, user-friendly platform for gamers seeking affordable game keys, aiming to become the top destination for accessible, high-quality digital gaming.

> **"SO AFFORDABLE IT'S LIKE STEALING!"** 

----

## A7: Web Resources Specification

This artifact documents the architecture of the web application to be developed, indicating the catalog of resources, the properties of each resource, and the format of JSON responses. This page includes the following operations over data: create, read, update, and delete.

### 1. Overview

> Identify and overview the modules that will be part of the application.  

| Module | Description |
|--|--|
| M01: Authentication and Profile | Web resources associated with user authentication and profile management, including basic user information and roles. |
| M02: Products Browse | Web resources associated with the search, filtering, sorting, and listing of available products, as well as browsing product information. |
| M03: Shopping Cart and Checkout | Web resources associated with adding products to the shopping cart and proceeding to checkout, including navigation of purchase history. |
| M04: User Administration | Web resources associated with administrative functions, including listing and managing users, managing products and their properties, and maintaining the shop's functionality. |
| M05: Static Pages | Web resources associated with static content and pages such as About, Contact, and FAQs. |

|M06: Order Management|Web resources associated with managing orders, including order tracking, status updates, and order history.|
|M07: Reviews and Ratings|Web resources associated with submitting and managing product reviews and ratings.|
|M08: Notifications|Web resources associated with sending and managing notifications for various events such as order updates, promotions, and user activities.|

### 2. Permissions

> Define the permissions used by each module, necessary to access its data and features.  

| Role | Description | Permissions |
| -- | -- | -- |
| **ANM** | Anonymous | Users without privileges |
| **USR** | User | General authenticated users |
| **BYR** | Buyer | Authenticated users who can purchase products and leave reviews |
| **SLR** | Seller | Authenticated users who can list products for sale |
| **ADM** | Administrator | System administrators |


### 3. OpenAPI Specification

> OpenAPI specification in YAML format to describe the vertical prototype's web resources.

> Link to the `a7_openapi.yaml` file in the group's repository.


```yaml
openapi: 3.0.0

...
```

---


## A8: Vertical prototype

> Brief presentation of the artifact goals.

### 1. Implemented Features

#### 1.1. Implemented User Stories

> Identify the user stories that were implemented in the prototype.  

| User Story reference | Name      | Priority    | Responsible        | Description                                           |
| -------------------- | --------- | ----------- | ------------------ | ----------------------------------------------------- |
| US01                 | Name of the user story | Priority of the user story | Main responsible by the implementation | Description of the user story |

...

#### 1.2. Implemented Web Resources

> Identify the web resources that were implemented in the prototype.  

> Module M01: Module Name  

| Web Resource Reference | URL                            |
| ---------------------- | ------------------------------ |
| R01: Web resource name | URL to access the web resource |

...

> Module M02: Module Name  

...

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
GROUPYYgg, DD/MM/20YY
 
* Group member 1 name, email (Editor)
* Group member 2 name, email
* ...