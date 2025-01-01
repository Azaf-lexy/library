# library
# Library Management System Documentation

## Overview
The Library Management System is designed to manage user registration, login, and book management efficiently. It allows different user roles (e.g., students, librarians) to perform specific actions such as borrowing books, returning them, and managing book inventory.

---
## admin email and password
- email : admin@gmail.com
-password :admin123
## student email and password
- email : johnduo@gmail.com
-password :1234
## git repo
-git repo link: https://github.com/Azaf-lexy/library.git
## Features
1. **User Management**
   - User Registration
   - Login with Secure Password Verification
   - Role-Based Session Management (e.g., Student, Librarian)

2. **Book Management**
   - Adding, Editing, and Deleting Books
   - Viewing Book Inventory
   - Managing Book Borrowing and Returning

3. **Fine Calculation**
   - Automated calculation of fines based on due dates and return dates.

4. **Responsive Design**
   - Web-based user interface compatible with multiple devices.

---

## Technical Stack
- **Frontend**: HTML, CSS, Bootstrap
- **Backend**: PHP
- **Database**: MySQL
- **Environment**: XAMPP (Apache, MySQL, PHP)

---

## Installation and Setup
1. **Prerequisites**:
   - Install XAMPP (or any suitable server environment).
   - Enable Apache and MySQL in XAMPP.

2. **Database Setup**:
   - Import the provided SQL file (`library_system.sql`) into your MySQL database.
   - Create a database named `library_system`.

3. **Code Setup**:
   - Place the project folder in the `htdocs` directory of XAMPP.
   - Update the database connection file (`config.php`) with the correct credentials:
     ```php
     <?php
     $host = 'localhost';
     $db = 'library_system';
     $user = 'root';
     $pass = '';

     try {
         $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
         $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     } catch (PDOException $e) {
         die("Connection failed: " . $e->getMessage());
     }
     ?>
     ```

4. **Run the Application**:
   - Open your browser and navigate to `http://localhost/library_system`.

---

## Code Structure
```
library_system/
|— config.php           # Database connection
|— functions.php        # Contains reusable functions
|— login.php           # User login script
|— register.php        # User registration script
|— librarian/
    |— display_books.php # Librarian dashboard to manage books
|— student/
    |— borrow.php       # Book borrowing page for students
|— assets/
    |— css/            # Stylesheets
    |— js/             # JavaScript files
```

---

## Key Functionalities

### 1. **User Registration**
   - **Endpoint**: `register.php`
   - **Fields**:
     - Name
     - Email
     - Password
   - **Flow**:
     1. Validate and sanitize input.
     2. Hash the password using `password_hash()`.
     3. Store user details in the `users` table.

### 2. **User Login**
   - **Endpoint**: `login.php`
   - **Flow**:
     1. Sanitize input and retrieve user by email.
     2. Verify password using `password_verify()`.
     3. Start a session and set role-specific session variables.

### 3. **Book Management**
   - **Endpoint**: `librarian/display_books.php`
   - **Features**:
     - Add books with title, author, and ISBN.
     - Edit or delete existing book entries.

### 4. **Borrowing and Returning**
   - **Borrow Endpoint**: `student/borrow.php`
   - **Return Logic**: Update `return_date` in the database and calculate fines based on overdue days.

### 5. **Fine Calculation**
   - **Logic**:
     ```sql
     UPDATE borrow
     SET fine = CASE
         WHEN return_date > due_date THEN DATEDIFF(return_date, due_date) * 20
         WHEN CURDATE() > due_date AND return_date IS NULL THEN DATEDIFF(CURDATE(), due_date) * 20
         ELSE fine
     END;
     ```

---

## Security Measures
1. **Password Hashing**:
   - All passwords are hashed using `password_hash()` for secure storage.
2. **Prepared Statements**:
   - SQL queries use prepared statements to prevent SQL injection.
3. **Session Management**:
   - Role-based access control and session variables ensure proper authentication.

---

## Future Enhancements
1. **Advanced User Roles**:
   - Add roles like Admin for system-wide management.
2. **Book Reservation**:
   - Allow users to reserve books in advance.
3. **Reporting**:
   - Generate detailed reports for book usage and fines.
4. **Notifications**:
   - Email notifications for overdue books and fines.

---

## Troubleshooting
1. **Database Connection Issues**:
   - Ensure XAMPP MySQL is running.
   - Verify database credentials in `config.php`.
2. **Login Failures**:
   - Check if the `users` table has valid entries.
   - Verify password hashing matches during registration and login.
3. **File Not Found**:
   - Ensure correct paths in `include` or `require` statements.

---

## Contact
For support or queries, contact the development team:
- **Email**: support@librarysystem.com
- **Phone**: +1-800-LIBRARY

