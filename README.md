# TrackMyBugs

TrackMyBugs is a simple PHP based bug and project tracking application. It provides user authentication, project management, bug reporting, comments, and notifications through a clean web interface and JSON APIs.

## Features

- User registration, login, password recovery
- Project and bug management
- Bug comments and status updates
- Live API endpoints for dashboards
- In app and email notifications

## Project Structure

- `public/`  
  Entry point for the application. Contains pages, API endpoints, and static assets like CSS and JavaScript.

- `src/`  
  Core application logic written using object oriented programming.
  - `Classes/` contains domain classes such as `User`, `Project`, `Bug`, and `Comment`.
  - `Interfaces/` defines contracts such as `NotificationInterface`.
  - `Services/` contains service classes like `NotificationService` that coordinate behavior.

- `templates/`  
  Reusable PHP templates for rendering pages.

- `config/`  
  Application configuration files.

- `sql/`  
  Database schema and seed data.

- `logs/`  
  Application logs.

## Object Oriented Design

The application follows OOP principles:

- Each core concept is represented by a class, for example `Bug`, `Project`, and `User`.
- Business logic is encapsulated within classes instead of being placed in page controllers.
- Services are used to separate coordination logic from domain models.

## Interfaces

Interfaces are used to define clear contracts and support extensibility.

- `NotificationInterface` defines how notifications should behave.
- Concrete implementations such as `EmailNotification` and `InAppNotification` implement this interface.
- This allows the `NotificationService` to work with different notification types without being tightly coupled to specific implementations.

## Requirements

- PHP 8 or higher
- MySQL or compatible database
- Composer

## Setup

1. Clone the repository
2. Install dependencies with Composer
3. Import the SQL file from `sql/`
4. Configure database credentials in `config/config.php`
5. Point your web server to the `public/` directory

## Testing

The `tests/` directory is reserved for automated tests and future test coverage.

## License

This project is for educational and internal use.
