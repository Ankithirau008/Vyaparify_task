# Mini Blog Management System - Laravel

A fully functional **Mini Blog Management System** built using **Laravel** with robust features such as authentication, CRUD operations for posts, categories, and tags, an admin panel for approval/rejection of posts, a public blog interface, API integration, and comprehensive testing.

---

## 🌟 Features

### 1. **Authentication**
   - Laravel Breeze or Jetstream for authentication.
   - Roles: **Admin** and **Author**.
   - **Admin** has full access to manage users, categories, tags, and posts.
   - **Authors** can only manage their own posts.

### 2. **Database Schema**
   - Migrations to create tables for **users**, **posts**, **categories**, and **tags**.

### 3. **Admin Panel**
   - **Dashboard** displaying the total number of posts, categories, and users.
   - **CRUD** operations for posts, categories, and tags.
   - Admins can **approve/reject** posts submitted by authors.

### 4. **Author Features**
   - **CRUD** operations for posts.
   - Posts created by an author are **"draft"** by default until approved by an admin.

### 5. **Frontend**
   - Public-facing **blog interface**.
   - Display **posts** in **categories** and **tags**.
   - **Search functionality** for posts.
   - **Post detail page** with related posts.

### 6. **Advanced Features**
   - File upload for the **featured image** using **Laravel's Storage facade**.
   - **Eloquent relationships** for posts, categories, and tags.
   - Optimized queries using **eager loading**.
   - **Server-side validation** of form inputs.
   - Role-based access control using **policies** or **gates**.

### 7. **API**
   - Create an **API** to fetch **published posts** with pagination.
   - Filters for **category** and **tags**.
   - **Secure the API** using **Laravel Sanctum** for authentication.

### 8. **Testing**
   - **Feature** and **unit tests** for posts, categories, and authentication.

---

## 🚀 Setup Instructions

Follow the steps below to set up the **Mini Blog Management System** on your local machine.

### Prerequisites

- PHP >= 8.0
- Composer
- Laravel 8.x or above
- MySQL or SQLite
- Node.js and npm (for front-end assets)

### Step 1: Clone the Repository
```bash
git clone https://github.com/your-username/mini-blog-system.git
cd mini-blog-system
