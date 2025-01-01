

CREATE TABLE add_books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    book_name VARCHAR(255) NOT NULL,
    author_name VARCHAR(255) NOT NULL,
    purchase_date DATE NOT NULL,
    quantity INT NOT NULL,
    image_path VARCHAR(255)
);



CREATE TABLE borrow (
    borrowId INT AUTO_INCREMENT PRIMARY KEY,
    student_name VARCHAR(255) NOT NULL,
    book_name VARCHAR(255) NOT NULL,
    borrow_Date DATE NOT NULL,
    return_Date DATE NOT NULL,
    book_Id INT NOT NULL,
    borrow_Status INT NOT NULL,
    fine INT,
    due_date DATE
);

CREATE TABLE student_registration (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
     role enum('student','admin') 
     );

