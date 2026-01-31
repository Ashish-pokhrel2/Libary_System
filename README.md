# Library Management System

A simple web-based library management system built with PHP and MySQL.

## Login Credentials

**Admin Account:**
- Username: admin
- Password: password

**Test User Account:**
- Username: user
- Password: user123

## Setup Instructions

### Prerequisites
- XAMPP/LAMP/WAMP (PHP 7.4 or higher)
- MySQL Database
- Composer

### Installation Steps

1. **Extract the project files** to your web server directory (htdocs for XAMPP)

2. **Import the database**
   - Open phpMyAdmin
   - Create a new database called `library_system`
   - Import the provided SQL file (`library_system.sql`)

3. **Configure database connection**
   - Open `config/database.php`
   - Update your database credentials if needed (default: root with no password)

4. **Install dependencies**
   ```bash
   composer install
   ```

5. **Access the application**
   - Open your browser and go to: `http://localhost/LibarySystem/public/`
   - Login with the credentials above

## Features Implemented

### Authentication
- User registration with validation
- Login/Logout functionality
- Session management

### Book Management
- Add new books with details (title, ISBN, author, category)
- Edit existing book information
- Delete books from system
- View complete book catalog
- Search and filter books

### Author Management
- Add new authors
- Edit author details
- Delete authors
- View all authors in the system

### Category Management
- Create book categories
- Edit categories
- Delete categories
- View all categories

### Dashboard
- Overview of system statistics
- Quick access to all modules
- Clean and responsive interface

## Technical Details

- **Backend:** PHP (OOP approach)
- **Database:** MySQL
- **Frontend:** HTML, CSS, JavaScript
- **Template Engine:** Blade (Laravel-inspired)
- **Architecture:** MVC Pattern
- **Dependencies:** Managed via Composer

## Known Issues

- Pagination is not yet implemented for large datasets
- Book cover image upload feature is pending
- Advanced search with multiple filters needs refinement
- Email notifications for overdue books not implemented
- Cannot add new authors or categories directly from the book creation page - must navigate to respective pages first

## Project Structure

```
LibarySystem/
├── app/               # Application logic
│   ├── Controllers/   # Handle requests
│   ├── Models/        # Database interactions
│   └── views/         # Blade templates
├── config/            # Configuration files
├── public/            # Public accessible files
│   ├── css/          # Stylesheets
│   └── js/           # JavaScript files
└── vendor/           # Composer dependencies
```

## Notes

This project was developed as part of a web development course assignment. It demonstrates basic CRUD operations, authentication, and database management using PHP and MySQL.
