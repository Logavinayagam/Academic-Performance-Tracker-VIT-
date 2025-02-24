# Academic Performance Tracker (VIT)

## 📌 Project Overview
The **Academic Performance Tracker (VIT)** is a web-based platform designed to help students **track their grades, GPA, CGPA, attendance**, and set academic goals. It provides **real-time analytics, performance visualization, and study resources** to improve academic planning.

## 🚀 Features
✅ **User Authentication** (Register, Login, Profile Management)  
✅ **GPA Calculator** (Compute GPA based on courses, grades, and credits)  
✅ **CGPA Calculator** (Calculate CGPA using stored GPA data)  
✅ **Performance Chart** (Graphical representation of GPA & CGPA over semesters)  
✅ **Grade Calculator** (CAT-1, CAT-2, Assignments, Quiz, FAT Marks)  
✅ **Attendance Tracker** (Visual attendance tracking per subject)  
✅ **Goal Setting** (Set & analyze target CGPA, required GPA)  
✅ **Study Resources** (Links to learning platforms & VIT Library)  
✅ **Feedback Submission** (Automatically stored in database)  
✅ **Admin Panel** (To view user feedback - Future Enhancement)  

## 🛠 Technology Stack
- **Frontend:** HTML, CSS, JavaScript (Chart.js for visualization)
- **Backend:** PHP (Server-side scripting)
- **Database:** MySQL (XAMPP with port 4306)
- **Version Control:** GitHub
- **IDE:** VS Code

## ⚙️ Installation Steps
1️⃣ **Clone the Repository**
```bash
 git clone https://github.com/Logavinayagam/Academic-Performance-Tracker-VIT-.git
```
2️⃣ **Start XAMPP** and ensure MySQL is running on port `4306`  
3️⃣ **Import Database:** Import `academic_tracker.sql` in phpMyAdmin  
4️⃣ **Configure Database Connection:** Update `config/database.php`  
5️⃣ **Run the Project:** Open `http://localhost/Academic-Performance-Tracker/`  

## 📂 Database Schema
### **Tables & Schema:**
- **users** (Student authentication & profile data)
- **semesters** (Stores GPA & CGPA for each semester)
- **subjects** (Stores subject-wise grades and credits)
- **attendance** (Tracks subject-wise attendance)
- **goals** (Stores academic goals & target CGPA)
- **feedback** (Records user feedback)


## 👥 Contributors
- **Logavinayagam** 
- **Thaarani** 
- **Varshika** 

## 🔮 Future Enhancements
- ✅ **Admin Panel to View Feedback & Manage Users**
- ✅ **Mobile App Integration**
- ✅ **AI-driven Study Recommendations**

📌 **This project is built to help students take control of their academic performance and improve their learning journey.** 🚀




