--  Insert Add book
 INSERT INTO add_books 
    (book_name, purchase_date, image_path,author_name,quantity) 
     VALUES
    ('Php And Mysql Programming','2024-03-12', './books_image/c0efe8eadd326a9c354249b1612bf2293ef6831574a9e3a30aa66ee2e449a2b2dd8267b57e0e4feee5911cb1e1a03a79.jpg','Ajith',30);
--  Insert Student
 INSERT INTO student_registration 
    (username, email, password,role) 
  VALUES
   ('Azaf','admin@gmail.com', '240be518fabd2724ddb6f04eeb1da5967448d7e831c08c8fa822809f74c720a9','admin'),
   ('John Duo','johnduo@gmail.com', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4','student');