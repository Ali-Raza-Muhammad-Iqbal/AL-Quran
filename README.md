# 📖 AL-Quran

**AL-Quran** is an open-source web application designed to provide a simple and convenient platform for **Holy Quran recitation** while allowing users to save their reading progress and easily continue from where they previously stopped.

The application uses **SQLite** as its database, making it lightweight, portable, and easy to run without requiring a separate database server such as MySQL.

---

## ✨ Features

* 📖 Read and recite the Holy Quran
* 👤 User registration and account creation
* 🔐 Secure user login system
* 📌 Save recitation progress
* 🔄 Continue from the last saved lesson
* 💾 Lightweight and portable SQLite database
* 📱 Responsive interface for mobile, tablet, and desktop
* 🎨 Bootstrap-based responsive UI
* 🌐 Open-source and easy to customize
* ⚡ Simple and lightweight architecture

---

## 🛠️ Technology Stack

| Technology     | Purpose                       |
| -------------- | ----------------------------- |
| **HTML5**      | Application structure         |
| **CSS3**       | Styling and customization     |
| **JavaScript** | Client-side functionality     |
| **Bootstrap**  | Responsive user interface     |
| **PHP**        | Backend and application logic |
| **SQLite**     | Portable database             |

---

## 🔄 How It Works

The application follows a simple workflow:

```text
Create Account
      ↓
    Login
      ↓
Read / Recite Quran
      ↓
Complete Recitation
      ↓
Save Lesson / Progress
      ↓
Continue From Last Saved Lesson
```

### 1. Create an Account

A new user can create an account by providing the required registration information.

### 2. Login

After registration, the user can log into their personal account.

### 3. Recite the Quran

The user can navigate through the Quran and recite the required portion.

### 4. Save Lesson

After completing a recitation session, the user can save their current lesson/progress.

### 5. Continue Where You Left Off

When the user returns later, the application can use the saved progress to help them continue their recitation from where they previously stopped.

---

## 🗄️ Why SQLite?

AL-Quran uses **SQLite** instead of a traditional database server to make the application highly portable.

With SQLite:

* No MySQL server is required
* No database server configuration is needed
* The database is stored in a local file
* Easy to backup and transfer
* Suitable for lightweight applications
* Easy to deploy on local machines
* Convenient for development and educational purposes

This makes AL-Quran easy to run on systems where installing and configuring MySQL would be unnecessary.

---

## 📂 Project Structure

A typical project structure can look like:

```text
AL-Quran/
│
├── assets/
│   ├── css/
│   ├── js/
│   └── images/
│
├── config/
│   └── database.php
│
├── database/
│   └── quran.sqlite
│
├── auth/
│   ├── login.php
│   ├── register.php
│   └── logout.php
│
├── quran/
│   ├── index.php
│   └── lesson.php
│
├── progress/
│   └── save_progress.php
│
├── index.php
└── README.md
```

> The actual directory structure may vary depending on the implementation.

---

## 🚀 Getting Started

### Prerequisites

Make sure your system has:

* PHP 8.0+ recommended
* SQLite support enabled in PHP
* A web server such as:

  * XAMPP
  * Apache
  * PHP Built-in Development Server

No MySQL installation is required.

---

### Installation

#### 1. Clone the Repository

```bash
git clone https://github.com/your-username/AL-Quran.git
```

#### 2. Move the Project

If you are using XAMPP, place the project inside:

```text
xampp/htdocs/
```

For example:

```text
xampp/htdocs/AL-Quran/
```

#### 3. Configure SQLite

Make sure the SQLite database file is available in the project's database directory.

PHP should have the following extensions enabled:

```ini
extension=pdo_sqlite
extension=sqlite3
```

Restart Apache after enabling the extensions.

#### 4. Start the Application

Start **Apache** from the XAMPP Control Panel.

Then open:

```text
http://localhost/AL-Quran/
```

---

## 🔐 User Authentication

AL-Quran provides a basic authentication system where users can:

* Create an account
* Login to their account
* Maintain their own recitation progress
* Save their completed lessons
* Continue their Quran recitation later

User-specific progress should be associated with the authenticated user's account so that each user can maintain an independent reading history.

---

## 📌 Progress Tracking

The core concept of AL-Quran is simple:

> **Read → Complete → Save → Continue**

After completing a lesson, the user can save their current position. When they return to the application, their saved lesson helps them identify where they previously stopped.

This makes the application useful for users who want to maintain a consistent Quran recitation routine.

---

## 💾 Database

The application uses SQLite to store application data.

Example conceptual tables:

```text
users
├── id
├── name
├── email
├── password
└── created_at

lessons
├── id
├── user_id
├── surah
├── ayah
├── progress
└── completed_at
```

The exact database schema may differ according to the implementation.

---

## 📱 Responsive Design

The frontend is built using **Bootstrap**, allowing the application to work across different screen sizes.

Supported devices include:

* 💻 Desktop
* 💻 Laptop
* 📱 Mobile
* 📟 Tablet

---

## 🔓 Open Source

AL-Quran is an open-source project.

Developers are welcome to:

* Study the source code
* Modify the application
* Improve existing features
* Fix bugs
* Add new functionality
* Submit pull requests

---

## 🤝 Contributing

Contributions are welcome!

To contribute:

```bash
# Fork the repository

# Clone your fork
git clone https://github.com/your-username/AL-Quran.git

# Create a new branch
git checkout -b feature/new-feature

# Make your changes

# Commit your changes
git commit -m "Add new feature"

# Push the branch
git push origin feature/new-feature
```

Then open a **Pull Request** on GitHub.

---

## 🔮 Future Improvements

Possible future features include:

* 🔖 Bookmark specific Ayahs
* 📊 Detailed recitation history
* 📅 Daily Quran reading goals
* 📈 Reading progress dashboard
* 🌙 Dark mode
* 🔍 Quran search
* 🔊 Audio recitation
* 🗣️ Multiple reciters
* 🌐 Multiple translations
* 📱 Improved mobile experience
* 🔔 Reading reminders
* 👤 User profile and statistics
* 📚 Multiple saved lessons

---

## ⚠️ Disclaimer

AL-Quran is an open-source software project created to provide a convenient interface for Quran recitation and personal reading-progress tracking.

Users should verify Quranic text, translations, and other religious content against reliable and authoritative sources.

---

## 📄 License

This project is open source. Add your preferred license to the repository, such as:

```text
MIT License
```

See the `LICENSE` file for the complete license terms.

---

## ❤️ Purpose

AL-Quran is built with the goal of making Quran recitation **simple, accessible, and organized**, while helping users remember where they last stopped in their reading journey.

> **Read. Recite. Remember. Continue.**

---

### ⭐ Support the Project

If you find **AL-Quran** useful, consider giving the repository a ⭐ on GitHub and contributing improvements to help make the project better.
