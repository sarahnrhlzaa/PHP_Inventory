# 🧪 Inventory Laboratorium System

> **Modern, Real-time, & Secure.** A web-based laboratory inventory management system designed to handle equipment borrowing, stock monitoring, and condition reporting.

---

## 📖 About The Project

This project was developed as a Final Project for the **Distributed Systems** course at **CEP-CCIT FTUI**. The system architecture separates the **Backend (Java Spring Boot)** and the **Frontend (Native PHP)**, communicating via a **RESTful API**.
***Check the Backend at: https://github.com/neyzamaylanies/inventory_laboratorium.git!***

The application aims to replace manual laboratory recording, prevent the borrowing of damaged equipment, and monitor stock availability in real-time for students.

### ✨ Key Features

* **🔐 Secure Authentication:** Secure login system with password encryption (BCrypt).
* **📊 Interactive Dashboard:** Real-time statistics, recent activities, and low-stock alerts.
* **🛒 Transaction Management:** Efficient recording of Borrowing (OUT) and Returning (IN) items.
* **🛡️ Smart Validation:** The system automatically rejects borrowing requests if the **Stock is Empty** or the **Equipment Condition is Damaged**.
* **📝 Condition Logging:** Track the history of equipment conditions (Good → Damaged → Under Repair).
* **🌍 Public Catalog:** Searchable equipment catalog for students (no login required).
* **👥 Role-Based Access:** Specific access rights for **Admins** and **Lab Staff**.

---

## 🛠️ Tech Stack

### **Backend (API Service)**
* **Language:** Java 25 (Oracle JDK)
* **Framework:** Spring Boot 4.0.1
* **Database:** MySQL
* **Docs:** Swagger UI / OpenAPI
* **Tools:** Maven, Lombok

### **Frontend (Client App)**
* **Language:** Native PHP 8.x
* **Styling:** CSS3 (Modern UI, Glassmorphism, Responsive)
* **Scripting:** Vanilla JavaScript
* **Communication:** cURL (REST API Consumer)

---

## 🚀 Installation & Setup

Follow these steps to run the system on your local machine.

### 1. Setup Database & Backend
1.  Create a MySQL database named `inventory`.
2.  Import the `db/inventory.sql` file into the database.
3.  Open the Backend project (Spring Boot) in your IDE (VS Code / IntelliJ).
4.  Run the application:
    ```bash
    ./mvnw spring-boot:run
    ```
5.  Ensure the Backend is running at `http://localhost:8080`.

### 2. Setup Frontend
1.  Ensure you have **XAMPP** or another PHP Web Server installed.
2.  Place the `PHP_Inventory` folder into your `htdocs` directory.
3.  Open `includes/api_helper.php` and verify the URL configuration:
    ```php
    define('API_BASE_URL', 'http://localhost:8080/api');
    ```
4.  Open your browser and access: `http://localhost/PHP_Inventory`.

---

## 👥 Authors

Developed with ❤️ by **Team 3FSD2 - CEP CCIT FTUI**:

* **Fullstack Engineer:** [Neyza Maylanie Santosa](https://github.com/neyzamaylanies) && [Sarah Nurhaliza](https://github.com/sarahnrhlzaa).

---

Copyright © 2025 Inventory Laboratorium System, CEP CCIT-FTUI. All Rights Reserved.
