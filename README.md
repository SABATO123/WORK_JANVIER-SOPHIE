# BusCab - Modern Bus Booking System

<p align="center">
  <img src="public/images/backgrounds/hero-bg.jpg" alt="BusCab" width="600">
</p>

BusCab is a modern, user-friendly bus booking system built with Laravel. It provides an efficient way for passengers to book bus tickets and for administrators to manage bus routes, bookings, and fleet operations.

## Features

### For Passengers
- 🎫 Browse available bus routes without registration
- 👤 User registration and authentication
- 🚌 View detailed bus information and seat availability
- 📅 Book tickets for available routes
- 💳 Manage bookings (view, cancel)
- 📱 Responsive design for mobile and desktop

### For Administrators
- 🚍 Manage bus fleet (add, edit, remove buses)
- 🛣️ Create and manage routes
- 📊 View booking statistics
- 👥 User management
- 🎟️ Booking management

## Technology Stack

- **Framework:** Laravel 10.x
- **Frontend:** 
  - Blade Templates
  - TailwindCSS
  - Alpine.js
- **Database:** MySQL
- **Authentication:** Laravel Breeze

## Project Structure

```
BusCab/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/         # Admin controllers
│   │   │   └── Passenger/     # Passenger controllers
│   │   └── Middleware/        # Custom middleware
│   └── Models/                # Eloquent models
├── database/
│   └── migrations/           # Database migrations
├── resources/
│   └── views/
│       ├── admin/           # Admin panel views
│       ├── passenger/       # Passenger views
│       └── layouts/         # Shared layouts
└── routes/
    └── web.php             # Web routes
```

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/yourusername/buscab.git
   cd buscab
   ```

2. Install dependencies:
   ```bash
   composer install
   npm install
   ```

3. Set up environment:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. Configure database in `.env`:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=buscab
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. Run migrations and seeders:
   ```bash
   php artisan migrate --seed
   ```

6. Link storage:
   ```bash
   php artisan storage:link
   ```

7. Build assets:
   ```bash
   npm run dev
   ```

8. Start the server:
   ```bash
   php artisan serve
   ```

## Default Users

After seeding, you can log in with these default accounts:

- **Admin:**
  - Email: admin@buscab.com
  - Password: password

- **Passenger:**
  - Email: user@buscab.com
  - Password: password

## Contributing

1. Fork the repository
2. Create your feature branch: `git checkout -b feature/my-new-feature`
3. Commit your changes: `git commit -am 'Add some feature'`
4. Push to the branch: `git push origin feature/my-new-feature`
5. Submit a pull request


