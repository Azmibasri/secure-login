# PHP Authentication System

A secure PHP-based authentication system with user registration, login, and dashboard functionality.

## Features

- **User Registration**: New users can create accounts with secure password handling
- **User Login**: Secure login system with session management
- **Dashboard**: Protected dashboard for authenticated users
- **Logout**: Secure logout functionality
- **Database Integration**: MySQL database for user data storage
- **Session Security**: Proper session management and security measures

## Project Structure

```
SECURE/
├── create_table.php    # Database table creation script
├── dashboard.php     # User dashboard (protected page)
├── db_connect.php    # Database connection configuration
├── index.php         # Main entry point (redirects to login)
├── login.php         # User login page
├── logout.php        # Logout functionality
├── register.php      # User registration page
└── README.md         # Project documentation
```

## Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web server (Apache/Nginx)

## Installation

1. Clone the repository:
```bash
git clone https://github.com/[your-username]/[repository-name].git
cd [repository-name]
```

2. Set up the database:
   - Create a MySQL database
   - Update `db_connect.php` with your database credentials
   - Run `create_table.php` to create the users table

3. Configure your web server to point to the project directory

4. Access the application through your web browser

## Configuration

### Database Configuration

Edit `db_connect.php` with your database credentials:

```php
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$database = "your_database";
```

### Environment Variables (for cloud deployment)

For cloud deployment, use environment variables instead of hardcoded credentials:

```php
$servername = $_ENV['DB_HOST'] ?? 'localhost';
$username = $_ENV['DB_USER'] ?? 'root';
$password = $_ENV['DB_PASS'] ?? '';
$database = $_ENV['DB_NAME'] ?? 'db_auth';
```

## Security Features

- Password security (should be hashed in production)
- Session management
- Input validation
- Database connection security
- Protected dashboard access

## Deployment Options

### Cloud Platforms

This application can be deployed to various cloud platforms:

- **Heroku**: PHP support with ClearDB MySQL
- **Vercel**: Serverless PHP deployment
- **DigitalOcean App Platform**: Container-based deployment
- **AWS Elastic Beanstalk**: Scalable PHP deployment

### Environment Variables for Cloud Deployment

Set these environment variables in your cloud platform:

```
DB_HOST=your_database_host
DB_USER=your_database_username
DB_PASS=your_database_password
DB_NAME=your_database_name
```

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Support

For support and questions, please open an issue in the GitHub repository.