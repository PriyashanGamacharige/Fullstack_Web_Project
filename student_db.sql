CREATE DATABASE student_db;

USE student_db;

CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    address VARCHAR(255),
    tel VARCHAR(20),
    nic VARCHAR(20) UNIQUE,
    course VARCHAR(100)
);

