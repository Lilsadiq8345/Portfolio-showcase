# PortfolioShowcase – Documentation

## Table of Contents
1. [Project Overview](#project-overview)
2. [Features](#features)
3. [Tech Stack](#tech-stack)
4. [Installation & Setup](#installation--setup)
5. [Environment Configuration](#environment-configuration)
6. [Running the Project](#running-the-project)
7. [Admin & User Access](#admin--user-access)
8. [Admin Panel Features](#admin-panel-features)
9. [User Panel Features](#user-panel-features)
10. [API Endpoints](#api-endpoints)
11. [Troubleshooting](#troubleshooting)
12. [Credits](#credits)

---

## Project Overview

**PortfolioShowcase** is a full-stack web application for managing and showcasing user portfolios. It features a robust admin panel for managing users and projects, and a user dashboard for personal portfolio management.

---

## Features

- **Authentication:** Secure login/register for users and admins.
- **Admin Panel:**  
  - Dashboard with user/project stats  
  - Manage users (add, edit, delete, search, filter, paginate)  
  - Manage projects (add, edit, delete, search, paginate)
- **User Panel:**  
  - View and edit profile  
  - View projects
- **Modern UI:** Responsive, clean, and accessible design using TailwindCSS.
- **API:** RESTful endpoints for all CRUD operations.

---

## Tech Stack

- **Backend:** Laravel (PHP 8+)
- **Frontend:** Vue.js 3, Vite, TailwindCSS
- **Database:** MySQL (or any Laravel-supported DB)
- **Auth:** Laravel Sanctum

---

## Installation & Setup

### 1. **Clone the Repository**
```bash
git clone <your-repo-url>
cd portfolio-showcase
```

### 2. **Backend Setup (Laravel)**
```bash
# Install PHP dependencies
composer install

# Copy and configure environment
cp .env.example .env
# Edit .env with your DB credentials

# Generate app key
/Applications/XAMPP/xamppfiles/bin/php artisan key:generate

# Run migrations and seeders
/Applications/XAMPP/xamppfiles/bin/php artisan migrate --seed
```

### 3. **Frontend Setup (Vue + Vite)**
```bash
npm install
```

---

## Environment Configuration

- This project uses **SQLite** by default for local development.
- Example DB section for `.env`:
  ```
  DB_CONNECTION=sqlite
  DB_DATABASE=/absolute/path/to/database/database.sqlite
  # Example: DB_DATABASE=/Applications/XAMPP/xamppfiles/htdocs/portfolio-showcase/database/database.sqlite
  ```
- To create the SQLite database file:
  ```bash
  touch database/database.sqlite
  ```
- If you want to use MySQL or another DB, update the `.env` accordingly.

---

## Running the Project

### **Development**
```bash
# Start Laravel backend
/Applications/XAMPP/xamppfiles/bin/php artisan serve

# Start Vite dev server
npm run dev
```

### **Production Build**
```bash
npm run build
# Make sure your web server serves the built assets from public/build
```

---

## Admin & User Access

### **Default Admin Credentials**


admin access url : http://127.0.0.1:8000/admin/login

- **Email:** `admin@admin.com`
- **Password:** `password`  
  *(or the password you set in your seeders or database)*

> **Note:** If you changed the admin password/email, use those values.

### **Registering Users**
- Users can register via the `/register` page.

### Demo Users

- After running the seeders, you can log in as:
  - **Email:** john.doe@example.com / **Password:** password
  - **Email:** jane.smith@example.com / **Password:** password

---

## Admin Panel Features

- **Sidebar Navigation:** Dashboard, Users, Projects
- **User Management:**  
  - List, search, filter, paginate users  
  - Add, edit, delete users  
  - Assign roles (User/Admin)
- **Project Management:**  
  - List, search, paginate projects  
  - Add, edit, delete projects
- **Advanced UI:**  
  - Confirmation dialogs for deletes  
  - Success/error notifications  
  - Responsive design

---

## User Panel Features

- **Dashboard:** View personal info and projects
- **Profile:** Edit profile details
- **Projects:** View available projects

### Image Uploads

- Uploaded project images are stored in `storage/app/public`.
- To make them accessible, run:
  ```
  php artisan storage:link
  ```

### Public Profile Example

- Visit `/profile/john.doe` or `/profile/jane.smith` to see public profiles.

### CORS/Frontend Note

- If using the Vite dev server, ensure CORS is enabled for API requests.
- The Vite dev server runs on port 5173 by default.

### Skill/Tag Management

- Skills/tags can be managed by the admin and assigned to users and projects.

### Contact

- For questions or support, contact [your email].

---

## API Endpoints

### **Authentication**
- `POST /api/login` – Login
- `POST /api/register` – Register

### **Admin**

- `GET /api/admin/users` – List users
- `POST /api/admin/users` – Add user
- `PUT /api/admin/users/{id}` – Edit user
- `DELETE /api/admin/users/{id}` – Delete user
- `GET /api/admin/projects` – List projects
- `POST /api/admin/projects` – Add project
- `PUT /api/admin/projects/{id}` – Edit project
- `DELETE /api/admin/projects/{id}` – Delete project

### **User**
- `GET /api/projects` – List user projects
- `POST /api/projects` – Add project (user)
- `PUT /api/projects/{id}` – Edit project (user)
- `DELETE /api/projects/{id}` – Delete project (user)

---

## Troubleshooting

- **Not seeing changes?**  
  - Hard refresh browser (`Cmd+Shift+R` or `Ctrl+F5`)
  - Clear Laravel cache:  
    `/Applications/XAMPP/xamppfiles/bin/php artisan cache:clear`
  - Rebuild assets: `npm run build`
  - Restart dev servers

- **PHP not found?**  
  - Use full path: `/Applications/XAMPP/xamppfiles/bin/php`

---

## Credits

- Built by Abubakar 
- Powered by Laravel, Vue.js, TailwindCSS


