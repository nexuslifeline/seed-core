#!/bin/bash

echo "📦 Building containers..."
docker-compose build

echo "🚀 Starting containers..."
docker-compose up -d

echo "🛠 Installing Laravel dependencies..."
docker-compose exec backend composer install

echo "🔑 Generating app key..."
docker-compose exec backend php artisan key:generate

echo "🧱 Running migrations..."
docker-compose exec backend php artisan migrate

echo "🌍 Starting Laravel development server..."
docker-compose exec -d backend php artisan serve --host=0.0.0.0 --port=8000

echo ""
echo "✅ All services are up and ready!"
echo ""
echo "🔗 Laravel Backend: http://localhost:8000"
echo "🔗 React Frontend: http://localhost:5173"
echo "🐬 MySQL Host: localhost:3307 (user: root, password: root)"
