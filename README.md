# Wilmar Buku

Wilmar Buku is a comprehensive web-based library and book management system. The application is designed to handle the core operations of a library, including inventory management, book borrowing and returns, user authentication, and data reporting. It provides a centralized dashboard for administrators to monitor transactions and a user-facing platform for browsing and checking out books.

## Motivation and Architecture

Traditional library management systems often suffer from fragmented data, slow transaction processing, and outdated user interfaces. Wilmar Buku was developed to modernize this workflow by providing a robust, real-time platform that minimizes manual administrative overhead.

From an architectural standpoint, the system relies on the TALL stack (Tailwind, Alpine.js, Laravel) to decouple the frontend reactivity from heavy JavaScript frameworks, keeping the application lightweight. It leverages Laravel's service container and Eloquent ORM for streamlined data access, and integrates Laravel Reverb for real-time WebSocket communication, ensuring immediate synchronization of book availability and system notifications across active clients. 

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

- **OAuth 2.0 Authentication**: Secure single sign-on integration allowing users to authenticate via their Google accounts, reducing friction and password management overhead.
- **Inventory and Asset Management**: Full lifecycle management of library assets with automated cover image processing and resizing using Intervention Image.
- **Transactional Checkout System**: A robust borrowing engine optimized with composite database indexing to handle concurrent checkout requests efficiently.
- **Real-Time Event Broadcasting**: Immediate UI updates and notifications for book availability and transaction status powered by WebSockets.
- **Automated PDF Reporting**: Programmatic generation of checkout logs, inventory status, and user activity reports for administrative compliance.
- **Analytical Dashboard**: Interactive metrics and historical data visualization utilizing Chart.js to help administrators make data-driven decisions.

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

4. **Initialize the database**
   Ensure your MySQL server is running and the database specified in your `.env` is created. Run the migrations to build the schema.
   ```bash
   php artisan migrate
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

The following configuration keys must be defined in your `.env` file to enable all application features.

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
| `MAIL_MAILER` | Mail driver used for system notifications | `smtp` |

## Project Structure

```text
wilmarbuku/
├── app/
│   ├── Http/Controllers/    # Request handling logic (e.g., KatalogController, PesanController)
│   ├── Repositories/        # Data access abstraction (e.g., BukuRepository)
│   └── Models/              # Eloquent models
├── database/
│   └── migrations/          # Schema definitions and indexing
├── resources/
│   └── views/               # Blade templates and frontend architecture
├── routes/
│   └── web.php              # HTTP routing definitions
└── public/                  # Publicly accessible assets and entry point
```

## License and Author Information

This project is open-source software licensed under the MIT License.

- **GitHub**: [https://github.com/Apisikma123](https://github.com/Apisikma123)
- **Email**: agaputra62@gmail.com
