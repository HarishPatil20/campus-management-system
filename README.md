# 🎓 Campus Management System (DBMS Mini Project)

This is a PHP + MySQL based **Campus Management System** developed as a DBMS mini project.  
It helps manage students, departments, courses, library, hostel, faculty, grades, and more through a web interface.

🌐 **Live Demo:**  
https://camps-management.rf.gd/Dbms_project/

---

## 🚀 Features

### 👤 Authentication
- Login & Register system
- Logout functionality
- Admin dashboard

### 🎓 Student Management
- Add students
- View students
- Update student details
- Delete students

### 🏫 Department & Course Management
- Add and view departments
- Add and view courses
- View course details

### 📚 Library Management
- View library records
- Add and view library details
- Select and view library data

### 🏠 Hostel Management
- Add hostel students
- View hostel details
- Update hostel student records
- Delete hostel students

### 📊 Grades & Marks
- Add grades
- View grades
- Mark submitted / not submitted

### 👨‍🏫 Faculty Management
- Add faculty
- View faculty details

---

## 🗂️ Project Structure
Dbms_project/
│── config.php
│── index.php
│── login_register.php
│── logout.php
│── student.php
│── student_view.php
│── student_update.php
│── department.php
│── courses.php
│── library.php
│── hostel.php
│── faculty.php
│── grade.php
│── style.css
│── script.js
│── image/
│── database/
│ └── clg.sql

---

## 🛠️ Tech Stack

- **Frontend:** HTML, CSS, JavaScript
- **Backend:** PHP
- **Database:** MySQL
- **Server:** Apache (XAMPP / InfinityFree)
- **Hosting:** InfinityFree

---

## 🗄️ Database Setup

1. Create a MySQL database on your server
2. Import the file:

## ▶️ How to Run Locally

1. Install XAMPP
2. Copy the project to:
   C:\xampp\htdocs\Dbms_project
3. Start Apache and MySQL
4. Open phpMyAdmin and import:
   database/clg.sql
5. Open browser and go to:
   http://localhost/Dbms_project/
   
## 📌 Future Enhancements

- Attendance Management  
- Online Assignment Submission  
- Role-based Dashboards  


## 🔒 Security Note

Before making this repository public, remove real database credentials from `config.php` and use placeholders.
