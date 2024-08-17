# RIN2 Project

## Overview

The RIN2 Project is a comprehensive user notification management system built with Laravel 8. It allows administrators to create, manage, and deliver notifications to users. Users can view, manage, and mark notifications as read. The project includes advanced features like user impersonation by admin, robust notification settings, and a search and filter functionality for notifications and users.

## Features

- **Admin Dashboard:**
  - Manage users and their notifications.
  - Create and post notifications to all users or specific users.
  - Impersonate users to manage their accounts and notifications.


      ![Admin Dashboard](https://i.ibb.co/mzRwcDd/Screenshot-1.png)


      ![Post Notifications](https://i.ibb.co/Pc33pJ7/Screenshot-3.png)




  

- **User Dashboard:**
  - View and manage notifications.
  - Update account and notification settings, including toggling on-screen notifications.
  - Real-time notification counter in user dashboard section.
  - If notifications are switched off, the counter will be hidden from the user dashboard, but users/admin can still view unread notifications by clicking the notification icon.

    ![User Dashboard](https://i.ibb.co/tmhkVw9/Screenshot-5.png)

    ![User Settings](https://i.ibb.co/Jvk9Srm/Screenshot-6.png)

    

- **Authentication:**
  - Secure login system with role-based access control.
  - Redirects users to their respective dashboards upon login.
  
    ![Login](https://i.ibb.co/syYQdwf/Screenshot.png)


- **Search and Filters:**
  - Search and filter notifications by type, target, and expiration.
  - Search users by email and phone number.

    ![Notifications List](https://i.ibb.co/qpyG2mC/Screenshot-4.png)


- **Notifications:**
  - Admins can view notifications without marking them as read.
  - Users can view their notifications and mark them as read
  - Scheduled job handling for sending notifications to all users.
  - All notification postings with the target type "all users" are managed through queued jobs to ensure efficient processing and delivery.

      ![User Notifications](https://i.ibb.co/n3tnXNF/Screenshot-7.png)


### Prerequisites

Ensure that you have the following installed on your local development machine:

- PHP 7.4 or higher
- Composer
- MySQL

### Steps to Install and Run

## Installation

Follow these steps to get the project up and running on your local machine.

### 1. Clone the Repository


git clone https://github.com/hdwivedi1193/notify_system.git

cd notify_system

### 2. Install Dependencies

Install all the required packages using Composer:

composer install


### 3. Set Up Environment Variables


Update the `.env` file with your database details:

DB_DATABASE=notify_system

DB_USERNAME=your_database_username

DB_PASSWORD=your_database_password

### 4. Setup Mysql DB
Make sure the notify_system database exists in your MySQL server. You can create it manually through a MySQL client or use a command-line tool:

CREATE DATABASE notify_system;

### 5. Run Migrations and Seeders

php artisan migrate

php artisan db:seed --class=UsersTableSeeder

### 6. Start the Queue Worker

Run the following command in a separate terminal window or tab

php artisan queue:work

### 7. Serve the Application

Start the local development server:

php artisan serve

### 8. Access the Application

http://localhost:8000

### 9. Demo Admin Credentials

For demo purposes, you can log in with the following admin credentials:

Email: admin@example.com

Password: password

## Additional Information

- **Notification Settings**: Users can toggle on-screen notifications on/off. If notifications are switched off, the counter will be hidden from the dashboard, but users can still view unread notifications by clicking the notification icon.

- **Authorization**: Authorization is implemented to ensure that only authorized users can perform certain actions, such as viewing or posting notifications.

- **Phone Validation**: The project uses the Propaganistas Laravel Phone package for phone number validation.

- **Search Criteria**: For search functionality, the project utilizes Beathon package, a minimal interface for the criteria pattern.

This `README.md` file covers all aspects of installation, configuration, and running the application, including setting up the database and running the queue worker.

Happy Coding