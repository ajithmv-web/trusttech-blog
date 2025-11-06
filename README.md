Installation
1. Clone the repository
git clone https://github.com/yourusername/trusttech-blog.git
cd trusttech-blog-portal

2 . Install PHP dependencies
composer install

3. Install Node.js dependencies (if using frontend assets)
npm install
npm run dev   # For development
# or
npm run build # For production

4. Configure Environment File

cp .env.example .env

5. Update .env with your database credentials and other settings:
APP_NAME="Trusttech Blog Portal"
APP_ENV=local
APP_KEY=base64:TE87rxUWZQfmOSn+9J1DWef1Jxu6ZxowPmXxH9LOi2s=
APP_DEBUG=true
APP_URL=http://localhost
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=trusttech_blog
DB_USERNAME=root
DB_PASSWORD=

6.. Generate Application Key
php artisan key:generate

7.Generate JWT Secret (if using API authentication)
php artisan jwt:secret

8.Run Migrations
php artisan migrate

9.Seed Default User
php artisan db:seed

10.Start Development Server
php artisan serve
Dashboard: http://127.0.0.1:8000
API Endpoint: http://127.0.0.1:8000/api/posts

11. Default User
Email: admin@trusttech.com
Password: Trusttech@2025!
