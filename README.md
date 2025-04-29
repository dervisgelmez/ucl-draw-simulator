<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12-red" alt="Laravel 12 Badge" />
  <img src="https://img.shields.io/badge/Vue-3-green" alt="Vue 3 Badge" />
</p>

# UCL Draw Simulator

This project simulates a draw for the UEFA Champions League tournament, built with **Laravel 12** (API) and **Vue 3** (Frontend).

## Getting Started

Follow the steps below to set up the project locally:

### 1. Clone the Repository

```bash
git clone git@github.com:dervisgelmez/ucl-draw-simulator.git
```
```bash
cd ucl-draw-simulator
```

### 2. Setup Environment Variables

```bash
cp api/.env.example api/.env
```

### 3. Start Docker Containers

```bash
docker compose up -d
```

### 4. Install Backend Dependencies

```bash
docker exec -it ucl-draw-php bash -c "composer install"
```

### 5. Run Migrations and Seed the Database

```bash
docker exec -it ucl-draw-php bash -c "php artisan migrate --seed"
```

## Access the Project

Once the steps above are completed, the project will be available at:

```
http://localhost
```

## Important Notice

If your local **port 80** is already in use, or if you prefer to run the project on a different port, you can modify the port settings in the `docker-compose.yaml` file.

---
