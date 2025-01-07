# Laravel Installer  

A **web-based Laravel installer package** designed to simplify project setup and configuration with an intuitive, lightweight interface. This package streamlines the process of verifying licenses, checking server requirements, managing folder permissions, setting up databases, and configuring admin credentials.  

---

## Features  

- **Lightweight User Interface**: A clean and simple UI for easy navigation during installation.  
- **Verify Envato License**: Ensures only authorized users can proceed with the installation process.  
- **Server Requirement Check**: Automatically checks for required PHP extensions and server configurations.  
- **Folder Permission Validation**: Ensures necessary folders have the correct permissions for Laravel to function smoothly.  
- **Automatic Database Migration**: Runs database migrations with seeders and demo data effortlessly.  
- **Admin Setup**: Guides you through setting up admin credentials during installation.  

---

## Installation  

To install the package, use Composer:  

```bash
composer require hashcode/laravel-installer
```
Register the Service Provider

Add the service provider to the providers array in config/app.php:


'providers' => [
```bash
    // Other Service Providers
    Hashcode\LaravelInstaller\Providers\LaravelInstallerServiceProvider::class,
```
],

Publish Assets

Publish the package's assets and configuration files by running:
```bash
php artisan vendor:publish --tag=laravel-installer
```
Usage
Access the Installer

After installation, navigate to the installer interface in your browser by visiting:
```bash
http://yourdomain.com/install
```
Step-by-Step Installation Process

License Verification: Enter your valid Envato license key to proceed.
Server Requirements: Ensure all server requirements are met.
Folder Permissions: Adjust folder permissions as needed.
Database Setup: Provide your database credentials and let the installer handle migrations with demo data.
Admin Setup: Enter your desired admin credentials to complete the installation.
##Note
If you ```do not``` want to run migrations and prefer to use an existing ```SQL``` file for the database:

``Place`` your ``SQL`` file in the ``database folder`` and name it ``database.sql``.
The installer will automatically detect and import the database.sql file instead of running migrations.
