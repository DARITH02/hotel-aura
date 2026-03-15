# Hosting on InfinityFree - Instructions

This project has been cleaned and optimized for hosting on InfinityFree or any regular PHP hosting service.

## 1. Database Setup
1. Log in to your InfinityFree control panel.
2. Go to **MySQL Databases** and create a new database.
3. Note down the **DB Host**, **DB Name**, **DB User**, and **DB Password**.
4. Open **phpMyAdmin** for your new database.
5. Import the file located at: `database/db_hotel.sql`.

## 2. Configuration
Open `config/config.php` and update the values:
- `host`: Your InfinityFree MySQL Host (e.g., `sql123.epizy.com`).
- `name`: Your InfinityFree MySQL Database Name.
- `user`: Your InfinityFree MySQL Username.
- `pass`: Your InfinityFree MySQL Password.
- `url`: Change `http://localhost/hotel-system-two` to your actual domain (e.g., `http://your-site.epizy.com`).

## 3. Uploading Files
Upload all files from this project directory to the `htdocs` folder on InfinityFree using FTP (e.g., FileZilla).

## 4. Telegram Webhook (Optional)
If you use the Telegram feature:
1. Update the `bot_token` in `config/config.php`.
2. Visit `your-domain.com/telegram/setup-webhook` in your browser to link the bot.

## Cleaned up files:
- Removed leftover junk CSS and HTML files from the root.
- Moved hardcoded credentials to `config/config.php`.
- Optimized `.htaccess` for security and clean URLs (hides `/public/` from URL).
