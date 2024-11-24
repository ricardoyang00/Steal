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