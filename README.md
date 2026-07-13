# CSquare ERP System

A small ERP web app built with PHP, MySQL, Bootstrap, CSS, and JavaScript for the
CSquare / MyBiz.lk Full Stack Developer intern assignment.

## Features
- Customer registration with list view (Title, First name, Last name, Contact number, District), with full validation.
- Item registration with list view (Item code, Item name, Category, Sub-category with dependent dropdown, Quantity, Unit price), with full validation.
- Invoice report — filterable by date range.
- Invoice item report — filterable by date range.
- Item report — one row per item.

## Setup instructions

1. Install XAMPP (or any Apache + PHP + MySQL stack).
2. Place this project folder inside your `htdocs` directory, e.g. `htdocs/erp_system`.
3. Start Apache and MySQL from the XAMPP control panel.
4. Open phpMyAdmin (`http://localhost/phpmyadmin`), create a database named `erp_database`.
5. Import the provided `erp_database.sql` file into that database (Import tab).
6. Check `includes/config.php` — default XAMPP credentials (`root` / no password) are already set.
7. Visit `http://localhost/erp_system/customers/index.php` in your browser.

## Assumptions made
- Invoices themselves are read-only in this app (pre-loaded from the provided database file) — only Customers and Items have full insert/update/delete, matching what the assignment explicitly asks for.
- Contact number is validated as exactly 10 digits.
- Category and Sub-category are stored as separate lookup tables (not free text), since the brief requires them to be selectable dropdowns, and sub-categories depend on the chosen category.