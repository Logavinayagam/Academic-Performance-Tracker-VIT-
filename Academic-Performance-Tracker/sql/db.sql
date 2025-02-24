-- Step 1: Create the Database
CREATE DATABASE academic_tracker;
USE academic_tracker;

-- Step 2: Users Table (Stores student login details)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id VARCHAR(10) UNIQUE NOT NULL,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- Step 3: Semesters Table (Stores GPA & CGPA for each semester)
CREATE TABLE semesters (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id VARCHAR(10) NOT NULL,
    semester_no INT NOT NULL,
    gpa DECIMAL(3,2),
    cgpa DECIMAL(3,2),
    FOREIGN KEY (student_id) REFERENCES users(student_id) ON DELETE CASCADE
);

-- Step 4: Subjects Table (Stores subject-wise grades and credits)
CREATE TABLE subjects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id VARCHAR(10) NOT NULL,
    semester_no INT NOT NULL,
    subject_code VARCHAR(10) NOT NULL,
    subject_name VARCHAR(255) NOT NULL,
    credits INT NOT NULL,
    grade VARCHAR(2), 
    FOREIGN KEY (student_id) REFERENCES users(student_id) ON DELETE CASCADE
);

-- Step 5: Attendance Table (Tracks attendance per subject)
CREATE TABLE attendance (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id VARCHAR(10) NOT NULL,
    semester_no INT NOT NULL,
    subject_code VARCHAR(10) NOT NULL,
    attended_classes INT NOT NULL,
    total_classes INT NOT NULL,
    FOREIGN KEY (student_id) REFERENCES users(student_id) ON DELETE CASCADE
);

-- Step 6: Goals Table (Tracks academic goals)
CREATE TABLE goals (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id VARCHAR(10) NOT NULL,
    goal VARCHAR(255),
    target_gpa DECIMAL(3,2),
    deadline DATE,
    FOREIGN KEY (student_id) REFERENCES users(student_id) ON DELETE CASCADE
);

-- Step 7: Study Resources Table (Stores recommended materials)
CREATE TABLE study_resources (
    id INT AUTO_INCREMENT PRIMARY KEY,
    topic VARCHAR(255) NOT NULL,
    recommended_material TEXT NOT NULL
);

CREATE TABLE feedback (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id VARCHAR(10) NOT NULL,
    message TEXT NOT NULL,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES users(student_id) ON DELETE CASCADE
);
