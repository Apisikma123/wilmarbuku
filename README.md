live website:https://donasi-buku.wbi.ac.id/

# Wilmar Buku

Wilmar Buku is a comprehensive web-based platform dedicated to managing library donations. The application is specifically designed to handle both internal and external donations, streamlining the contribution process for the library rather than traditional book borrowing and returns. It provides a centralized dashboard for administrators to monitor incoming donations and a user-facing platform for contributors to submit their donations.

## Motivation and Architecture

Traditional donation management processes often suffer from fragmented data, slow transaction processing, and outdated user interfaces. Wilmar Buku was developed to modernize this workflow by providing a robust, real-time platform dedicated specifically to library donations, minimizing manual administrative overhead.

From an architectural standpoint, the system relies on the TALL stack (Tailwind, Alpine.js, Laravel) to decouple the frontend reactivity from heavy JavaScript frameworks, keeping the application lightweight. It leverages Laravel's service container and Eloquent ORM for streamlined data access, and integrates Laravel Reverb for real-time WebSocket communication, ensuring immediate synchronization of donation updates and system notifications across active clients. 

Google OAuth is implemented via Laravel Socialite to ensure secure and frictionless user onboarding, delegating authentication security to Google's infrastructure.

## Tech Stack

**Backend**
- PHP 8.3
- Laravel 13.x
- MySQL
- Laravel Reverb (WebSocket server)
- Laravel Echo (Client-side event broadcasting)

**Frontend**
- Blade (Templating engine)
- Tailwind CSS (Utility-first styling)
- Alpine.js (Lightweight DOM manipulation)
- Chart.js (Data visualization)

**Libraries and Tools**
- Laravel Socialite (OAuth authentication)
- Intervention Image (Image manipulation and optimization)
- DomPDF (Automated PDF report generation)
- Vite (Frontend asset bundling)

## Features

- **Streamlined Authentication**: Fast and seamless user registration, instant password reset, and Google OAuth 2.0 Single Sign-On.
- **Role-Based Access Control**: Separate privileges and dashboards for administrators, internal campus users, and external contributors.
- **Internal & External Donations**: Comprehensive management of library donations from both internal students and external contributors.
- **Real-Time Event Broadcasting**: Immediate UI updates and notifications for donation status and processing powered by Laravel Reverb WebSockets.
- **Automated PDF Reporting**: Programmatic generation of donation logs and user activity reports for administrative compliance.
- **Analytical Dashboard**: Interactive metrics and historical data visualization utilizing Chart.js to help administrators make data-driven decisions regarding library donations.

## Default Credentials (Testing)

For development and evaluation purposes, default administrator credentials are provided via the database seeder:

| Role | Email | Password |
| :--- | :--- | :--- |
| **Admin** | `admin@wilmarbuku.com` | `password` |

## Getting Started

### Prerequisites

Ensure the following runtimes and services are installed on your host machine:
- PHP >= 8.3
- Composer >= 2.0
- Node.js >= 20.x and npm
- MySQL >= 8.0

### Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/Apisikma123/wilmarbuku.git
   cd wilmarbuku
   ```

2. **Install application dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Configure the environment**
   Copy the example environment configuration and generate the application encryption key.
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Initialize and Seed the database**
   Ensure your MySQL server is running and the database specified in your `.env` is created. Run the migrations and seeders:
   ```bash
   php artisan migrate --seed
   ```

5. **Start the local development servers**
   The project includes a unified npm script that utilizes `concurrently` to boot the PHP server, Vite, Queue Worker, and Reverb WebSocket server simultaneously.
   ```bash
   npm start
   ```
   
   To compile frontend assets for development:
   ```bash
   npm run dev
   ```

   The application will be accessible at `http://localhost:8000`.

## Environment Variables

The following configuration keys must be defined in your `.env` file to enable all application features:

| Variable | Description | Example Value |
| :--- | :--- | :--- |
| `DB_DATABASE` | Target MySQL database name | `wilmarbuku` |
| `DB_USERNAME` | Database user account | `root` |
| `DB_PASSWORD` | Database user password | `secret` |
| `GOOGLE_CLIENT_ID` | OAuth Client ID from Google Cloud Console | `your-client-id.apps.googleusercontent.com` |
| `GOOGLE_CLIENT_SECRET` | OAuth Secret from Google Cloud Console | `your-client-secret` |
| `GOOGLE_REDIRECT_URI` | Authorized redirect URI for Google Auth | `http://127.0.0.1:8000/auth/google/callback` |
| `REVERB_APP_KEY` | Public identifier for Reverb WebSockets | `your-reverb-key` |
| `REVERB_APP_SECRET`| Secret key for Reverb authentication | `your-reverb-secret` |
| `MAIL_MAILER` | Mail driver used for system logs/notifications | `log` |

## Project Structure

```text
wilmarbuku/
├── app/
│   ├── Http/Controllers/    # Request handling logic (e.g., AuthController, KatalogController, AdminController)
│   ├── Repositories/        # Data access abstraction (e.g., BukuRepository)
│   └── Models/              # Eloquent models
├── database/
│   ├── migrations/          # Schema definitions and indexing
│   └── seeders/             # Database seeders
├── resources/
│   └── views/               # Blade templates and frontend architecture
├── routes/
│   └── web.php              # HTTP routing definitions
└── public/                  # Publicly accessible assets and entry point
```

## License and Author Information

This project is open-source software licensed under the MIT License.

- **GitHub**: [https://github.com/Apisikma123](https://github.com/Apisikma123)
- **Email**: [agaputra62@gmail.com](https://mail.google.com/mail/?view=cm&fs=1&to=agaputra62@gmail.com)

- **GitHub**: [https://github.com/r4hmansun](https://github.com/r4hmansun)
- **Email**: [4rrahman5578@gmail.com](https://mail.google.com/mail/?view=cm&fs=1&to=4rrahman5578@gmail.com)

- **GitHub**: [https://github.com/M-RapeliHSN](https://github.com/M-RapeliHSN)
- **Email**: [raflyhusaini0290@gmail.com](https://mail.google.com/mail/?view=cm&fs=1&to=raflyhusaini0290@gmail.com)
