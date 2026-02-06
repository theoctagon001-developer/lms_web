@echo off
echo Starting Laravel server at 0.0.0.0:8080...
start cmd /k "php artisan serve --host=0.0.0.0 --port=8080"

echo Starting Vite (npm run dev)...
start cmd /k "npm run dev"


