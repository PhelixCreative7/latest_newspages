# College News Portal

## Overview
A PHP-based College News Portal web application that allows college administrators and teachers to post weekly or event-based news updates. Students and visitors can view all posted news on a public page.

## Tech Stack
- **Backend**: PHP 8.2 with PDO
- **Database**: PostgreSQL (Replit managed)
- **Frontend**: HTML5, CSS3, JavaScript
- **Server**: PHP built-in development server

## Features Implemented

### Public Features
- Public news page displaying all posts
- News cards showing title, description, event date, author, and optional image
- Posts displayed in reverse chronological order (newest first)
- Responsive design for mobile and desktop

### Admin Features
- Secure login system with password hashing
- Admin dashboard for managing news posts
- Add new news posts with:
  - Title
  - Description
  - Event date
  - Optional image upload (JPEG, PNG, GIF, WebP)
- Edit existing news posts
- Delete news posts
- View all posts created by the logged-in admin

### Security Features
- Session-based authentication
- Password hashing using PHP's `password_hash()`
- SQL injection prevention using PDO prepared statements
- Advanced file upload validation:
  - Server-side MIME type verification using `finfo`
  - Extension whitelist enforcement
  - File content validation (MIME type must match extension)
  - Randomized filenames to prevent overwrites
  - PHP execution disabled in uploads directory
- CSRF protection on all state-changing operations
- POST-only destructive actions (delete operations)
- Admin page access protection

## Project Structure
```
college-news/
├── db.php                  # Database connection (PDO)
├── index.php              # Public news display page
├── login.php              # Admin login page
├── logout.php             # Logout handler
├── dashboard.php          # Admin dashboard
├── add_news.php           # Add news form
├── edit_news.php          # Edit news form
├── delete_news.php        # Delete news handler
├── css/
│   └── style.css          # Responsive styles
├── includes/
│   ├── header.php         # Common header
│   ├── footer.php         # Common footer
│   └── auth_check.php     # Authentication guard
├── uploads/               # Uploaded images directory
├── .htaccess             # URL rewriting rules
└── .gitignore            # Git ignore file
```

## Database Schema

### Users Table
- `id` (SERIAL PRIMARY KEY)
- `username` (VARCHAR, unique)
- `password` (VARCHAR, hashed)
- `full_name` (VARCHAR)
- `created_at` (TIMESTAMP)

### News Table
- `id` (SERIAL PRIMARY KEY)
- `title` (VARCHAR)
- `description` (TEXT)
- `image` (VARCHAR, file path)
- `event_date` (DATE)
- `created_by` (INTEGER, foreign key to users.id)
- `created_at` (TIMESTAMP)

## Default Admin Credentials
- **Username**: admin
- **Password**: password

⚠️ **Important**: Change these credentials in production!

## How to Use

### For Students/Visitors
1. Visit the homepage to view all news posts
2. Browse news cards with images, titles, and descriptions
3. See event dates and author names

### For Admins/Teachers
1. Click "Admin Login" in the navigation
2. Login with credentials
3. From the dashboard:
   - Click "Add New News" to create a post
   - Click "Edit" to modify existing posts
   - Click "Delete" to remove posts
4. Upload images when adding/editing news (optional)

## Environment Variables
The application uses these PostgreSQL environment variables (managed by Replit):
- `PGHOST`
- `PGPORT`
- `PGDATABASE`
- `PGUSER`
- `PGPASSWORD`

## Recent Changes
- *October 10, 2025*: Security hardening and production readiness
  - Enhanced file upload security with server-side MIME validation
  - Added CSRF protection to all state-changing operations
  - Converted delete operations to POST-only with CSRF tokens
  - Disabled PHP execution in uploads directory
  - Implemented comprehensive file validation (extension + MIME type match)
- *October 10, 2025*: Initial project setup with complete CRUD functionality
  - Created PostgreSQL database with users and news tables
  - Implemented secure authentication system
  - Added image upload functionality with validation
  - Created responsive UI with mobile support
  - Set up PHP development server on port 5000

## Future Enhancements
Potential features to add:
- Pagination for browsing older news posts
- News categories (Events, Announcements, Sports)
- Search and filter functionality
- Admin user management
- Email notifications for new posts
- Rich text editor for news descriptions
- Multiple image uploads per post
