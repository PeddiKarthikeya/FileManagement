# FileManagement
File Upload Management System

This is a PHP-based web application that allows users to upload files, and provides role-based access control for administrators to manage and approve uploaded files. The application is designed with simplicity and security in mind, ensuring a streamlined process for managing file uploads in a multi-user environment.

Features:

*User Authentication:
Users can register and log in using their email and password.

*User roles: Admin and User.
Secure sessions and redirection based on user roles.


*Role-Based Access Control:
Admin:
Can upload, view, approve, and delete any files.
Access to all user-uploaded files, including pending approvals.
User:
Can upload files and view/download only admin-approved files.
Files uploaded by users are marked as pending until approved by an admin.

*File Upload and Storage:
Files are uploaded to the server in the uploads/ directory.
Each file includes metadata such as the uploader's name, user type, and the approval status.
File validation ensures secure handling of user uploads.

*Admin File Management:
Admins can view all uploaded files (approved and pending).
Approve or delete user-uploaded files directly from the dashboard.


*Database Integration:
Uses MySQL to manage users and file information.
Admin can track who uploaded each file, the status of the file (pending/approved), and the timestamp.



Project Structure:

The project consists of the following key files:

1.index.php: Handles user login based on roles (admin/user).
2.register.php: User registration page.
3.user.php: File upload form for users and admins.
4.admin.php: Admin dashboard for file management and approval.
5.view.php: Displays the list of files available for users and admins.
6.delete.php: Allows admins to delete files from both the server and the database.
7.logout.php: Logs out users and ends their session.


Database Structure:

The MySQL database consists of two key tables:

1. user_form:
Stores user information (name, email, password, and role).
Admins have full access to all functionalities, while regular users have restricted access.



2. files:
Stores information about uploaded files, including file path, file name, upload date, uploader's name, and approval status.




Technologies Used:

PHP: Core scripting language for server-side functionality.

MySQL: Database for storing user and file information.

HTML/CSS: Basic frontend for the file upload and management interface.

JavaScript: Minor client-side validation and interaction enhancements.


Security Considerations:

//User passwords are hashed using MD5 (for demonstration purposes), but it's recommended to upgrade to bcrypt or password_hash() for production use.
//All database queries should be secured with prepared statements to prevent SQL injection.
//Sessions are used for managing login states and restricting access based on user roles.


Future Enhancements:

->Implement pagination for large file lists.

->Add user notifications for file approval.

->Improve file upload security by validating file types and size limits.

->Migrate to bcrypt for password hashing for stronger security.


How to Run the Project

1. Clone the repository to your local machine.



2. Set up a MySQL database and create the required tables using the provided SQL script.


3. Modify the database connection settings in config.php and db.php according to your environment.


4. Start a local PHP server (e.g., using XAMPP or WAMP) and access the application via localhost.


5. Register a user, log in, and start uploading files. Use the admin account for file approvals.



License

This project is licensed under the MIT License.

