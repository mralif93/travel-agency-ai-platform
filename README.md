# TravelAI Platform

TravelAI Platform is a comprehensive, AI-powered travel agency management system built with **Laravel 12**. It facilitates vehicle booking management, driver assignments, and customer trip coordination.

## Key Features

- **Vertical Transport Rates & Booking**:
  - Simplified, mobile-responsive booking flow.
  - Interactive Map integration.
  - Dynamic vehicle selection (Sedan, MPV, Van, Bus).
  - Guest & Registered User support.
  - Automated price calculation.

- **Role-Based Dashboards**:
  - **Super Admin**: Full system oversight.
  - **Company**: Manage fleets and drivers.
  - **Driver**: View assignments and track earnings.
  - **Customer**: Manage bookings and view history.

- **Invoicing & Tickets**:
  - Auto-generated PDF Invoices/Receipts.
  - Digital Ticket Confirmation with QR Code tracking.

- **Customer Management**:
  - Easy password reset for admins (`P@ssw0rd123` default) with security confirmations.

## Recent Updates

### 1. Transport Rates & Booking System Redesign
- **Vertical Layout**: Redesigned `/transport-rates` with a vertical stack (Form -> Map -> Vehicles) for better mobile responsiveness.
- **Booking Engine**: Implemented full booking flow:
    -   Guest & Registered User support.
    -   Automated price calculation (server-side security).
    -   Order creation with status tracking.
- **Confirmation Page**: "Digital Ticket" style confirmation with QR code for order tracking.
- **PDF Invoice**: Auto-generated PDF invoices utilizing `dompdf`, streamable directly in-browser.

### 2. Customer Management Enhancements
- **Password Reset**: Admins can now reset customer passwords to a default (`P@ssw0rd123`) from both the **Index** (List) and **Edit** pages.
    -   **Security**: Integrated **SweetAlert2** for styled confirmation dialogs to prevent accidental resets.

### 3. Dashboard Improvements
- **Trip PDF**: Unified the design of the "Trip Details" PDF in the Customer Dashboard (`/customer/trips`) to match the clean, professional Booking Invoice layout.

## Tech Stack

- **Framework**: [Laravel 12.x](https://laravel.com)
- **Frontend**: [Tailwind CSS](https://tailwindcss.com), [Alpine.js](https://alpinejs.dev)
- **Database**: MySQL
- **PDF Generation**: `barryvdh/laravel-dompdf`
- **QR Codes**: `simplesoftwareio/simple-qrcode`

## Installation

1.  Clone the repository.
2.  Run `composer install`.
3.  Run `npm install && npm run build`.
4.  Copy `.env.example` to `.env` and configure your database.
5.  Run `php artisan key:generate`.
6.  Run `php artisan migrate --seed`.
7.  Serve the application: `php artisan serve`.

## License

The TravelAI Platform is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
