# How to secure WordPress Plugins (like a pro)

This repository demonstrates two implementations of a simple WordPress plugin that retrieves user data based on a URL parameter. Considering that WordPress powers most websites globally, this project is essential for highlighting and addressing the critical security gaps often found in such systems.
- **vulnerable:** Directly uses `$_GET` input in SQL queries without proper sanitization – leaving the door wide open for SQL injection attacks.
- **secure:** Implements a PDO-based approach with genuine prepared statements to securely handle public input.


---

## Table of Contents

- [Overview](#overview)
- [Important Note on WordPress Database Handling](#important-note-on-wordpress-database-handling)
- [Differences](#differences)
- [Installation & Testing](#installation--testing)
  - [Installation](#installation)
  - [Shortcode Usage](#shortcode-usage)
  - [Test Scenarios](#test-scenarios)
- [Why Security Matters](#why-security-matters)
- [Additional Resources](#additional-resources)
- [Final Note](#final-note)
- [License](#license)

---

## Overview

In today's digital landscape—with WordPress powering millions of websites and its user base growing year after year—it is more important than ever for developers to secure their plugins. This repository demonstrates two implementations of a simple WordPress plugin that retrieves user data based on URL parameters:

- **vulnerable:** Uses unsanitized public input directly in SQL queries, leaving your site wide open to SQL Injection attacks.
- **secure:** Implements a PDO-based approach with genuine prepared statements that securely handle user input.

By contrasting these two approaches, we emphasize that secure coding is essential when processing public input. An insecure plugin can turn your website into an open invitation for hackers, while a well-secured plugin helps maintain the integrity and safety of your site and its users.

**Key Advantages of the Secure Approach:**

- **True Prepared Statements:** Parameters are bound safely, keeping user input separate from the SQL command.
- **Enhanced Security:** Prevents SQL Injection vulnerabilities even if the input isn’t additionally sanitized.
- **Database Flexibility:** Easier migration between different database systems (e.g., MySQL, PostgreSQL, SQLite).

---

## Important Note on WordPress Database Handling

The native WordPress `$wpdb->prepare()` method is not a true prepared statement implementation like those provided by PDO. It uses a sprintf-like substitution mechanism to escape inputs, which does not fully separate the query structure from user data. In contrast, our secure approach leverages genuine PDO prepared statements, ensuring that parameters are bound securely at the database level. This offers a higher level of protection against SQL injection attacks.

---

## Differences

| Insecure (`vulnerable`)                     | Secure (`secure`)                              |
|---------------------------------------------|------------------------------------------------|
| Direct use of `$_GET` in SQL                | Uses PDO prepared statements                   |
| Vulnerable to SQL Injection attacks         | Protects against SQL Injection                 |
| Meant for demo purposes only 🔥              | Production-safe approach ✅                    |

---

## Installation & Testing

> [!WARNING]
>  The **vulnerable** version is intentionally insecure. **DO NOT INSTALL ON PUBLIC SERVERS!**

### Installation

1. Clone or download the repository.
2. In your **local** WordPress installation, place both plugin folders (`vulnerable` and `secure`) into the `/wp-content/plugins/` directory.
3. Activate both plugins from the WordPress admin.

### Shortcode Usage

- Insert the shortcode `[get_user]` into a page/post to test the vulnerable version.
- Insert the shortcode `[get_user_secure]` into a separate page/post for the secure version.

### Test Scenarios

#### SQL Injection Test

1. **Vulnerable Plugin:**
   - Navigate to your page with the `[get_user]` shortcode.
   - Append the URL parameter with an injection payload, for example:  
     `?user_id=1 OR 1=1 --`
   - **Expected Result:** The insecure plugin will likely return data for all users (SQL Injection successful).

2. **Secure Plugin:**
   - Navigate to your page with the `[get_user_secure]` shortcode.
   - Append the URL parameter with the same payload:  
     `?user_id=1 OR 1=1 --`
   - **Expected Result:** The secure plugin will treat the entire input as a parameter (likely as a non-numeric string) and return “No user found.”

---

## Why Security Matters

> **“An insecure plugin is like an open window in winter – anyone can get in, and you’ll be left shivering!”**

If your plugin processes public input without proper safeguards, you’re essentially inviting hackers inside. By using true prepared statements (e.g., with PDO), you help ensure that even if user input is malicious, it cannot alter the SQL commands executed by your database. With WordPress growing year after year and its vast audience, securing plugins is more critical than ever.

---

## Additional Resources

- [OWASP Top 10 – SQL Injection](https://owasp.org/www-project-top-ten/)
- [WordPress Plugin Developer Handbook – Security](https://developer.wordpress.org/plugins/security/)
- [PDO Prepared Statements](https://www.php.net/manual/en/pdo.prepared-statements.php)

---

## Final Note

This demo is designed to drive home the importance of secure coding practices in WordPress plugin development. Developers: **Make your plugins safe if they handle public input!** Don't let your code be an open invitation for hackers.

**Notes:**
- This repository contains a demo project that contrasts an insecure plugin with a secure one.
- *This README.md documentation was written with the help of OpenAI's ChatGPT o3-mini.*

---

## License

```
MIT License

Copyright (c) 2025 Volkan Kücükbudak

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the \"Software\"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included
in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED \"AS IS\", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
```

