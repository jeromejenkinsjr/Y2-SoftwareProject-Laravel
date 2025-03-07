# ![LiteraLeap Logo](literaleap/public/images/favicon.ico)

## LiteraLeap

### Bridging the Literacy Gap Through Interactive Learning

LiteraLeap is a **Laravel 12 and Bootstrap**-powered web platform designed to improve **English literacy** among children in developing regions. By integrating **interactive, game-based lessons**, multimedia study materials, and an accessible web interface, LiteraLeap ensures education is engaging and available to those who need it most.

## 🌍 Purpose

The idea behind the project is to provide **quality English education** to children in **underserved communities**, including Sierra Leone, Pakistan, and The Gambia, where literacy rates are low, and access to traditional education is limited.

## 🚀 Features

- **Gamified Learning** – Interactive exercises and animations that make reading fun.
- **Multimedia Integration** – Video and PDF-based study materials catering to different learning styles.
- **Web Accessibility** – A lightweight, browser-based platform ensuring easy access without app downloads.
- **Scalable Backend** – Built with Laravel 12 for seamless data management and performance.
- **Responsive Design** – Developed with Bootstrap for an optimized experience on all devices.

## 🛠️ Tech Stack

- **Frontend:** Bootstrap, HTML, CSS, JavaScript, p5.js
- **Backend:** Laravel 12, PHP
- **Database:** MySQL/PostgreSQL
- **Version Control:** Git & GitHub

## 🎯 How to Install & Run Locally

### Prerequisites:

- PHP 8.1+
- Composer
- Node.js & NPM (for frontend assets)
- MySQL/PostgreSQL

### Steps:

1. Clone the repository:
   ```sh
   git clone https://github.com/jeromejenkinsjr/Y2-SoftwareProject-Laravel
   ```
2. Install dependencies:
   ```sh
   composer install
   npm install
   ```
3. Set up the environment file:
   ```sh
   cp .env.example .env
   ```
   - Configure the database connection in the `.env` file.
4. Run database migrations:
   ```sh
   php artisan migrate --seed
   ```
5. Start the local development server:
   ```sh
   php artisan serve
   ```
6. Run frontend assets:
   ```sh
   npm run dev
   ```
7. Open **http://127.0.0.1:8000/** in your browser.

## 📧 Contact

For inquiries or collaboration, reach out at **n00230483@iadt.ie** or open an issue on GitHub.

---

_Empowering young learners, one lesson at a time!_
