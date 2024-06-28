# News App

## Run Locally

### Server

Go to the server directory from root directory

```bash
cd server
```

Install dependencies

```bash
composer install
```

Copy file .env.example to .env

```bash
cp .env.example .env
```

Run php artisan key:generate

```bash
php artisan key:generate
```

Run migration and seed

```bash
php artisan migrate --seed
```

Start the server

```bash
php artisan serve
```

### Client

Go to the client directory from root directory

```bash
cd client
```

Install dependencies

```bash
npm install
```

Start the server

```bash
npm run dev
```

Go to http://localhost:5173
