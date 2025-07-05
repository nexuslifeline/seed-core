# 🌱 Seed Core

**Seed Core** is a modern, open-source business platform for handling invoicing, procurement, and accounting. Built with **Laravel** on the backend and **React + Vite** on the frontend, it is designed for small to mid-sized businesses that need a robust yet flexible solution for managing financial workflows.

Seed Core helps you stay on top of **receivables, payables, inventory**, and **compliance-ready reports** — all via an API-first architecture you can self-host or extend.

---

## ✨ Key Features

### 🧾 Invoicing & Receivables
- Create professional invoices with branded templates.
- Track receivables and customer balances.
- Generate **Aging of Receivables** reports.
- Convert quotes or estimates into invoices.
- Support for recurring invoices and partial payments.

### 📦 Purchasing & Payables
- Manage the **purchase lifecycle**: estimates → purchase orders → payables.
- Track vendors, deliveries, and payment schedules.
- View **Aging of Payables** and open purchase reports.

### 📚 Double-Entry Accounting
- Full ledger-based system:
  - Chart of Accounts
  - Journal Entries
  - General Ledger
- Linked seamlessly to operational transactions.

### 📊 Built-in Financial Reports
- Income Statement (Profit & Loss)
- Balance Sheet
- Trial Balance
- Cash Flow Statement
- Journal and General Ledger
- Aging Reports (Receivables & Payables)

### 👥 Business Essentials
- Manage clients, vendors, employees, products, and services.
- Track inventory used in sales or purchases.

### 🔐 Auth & Access Control
- User login and role-based permission management.

### 🌐 API-First Backend
- REST API ready for frontend or third-party system integrations.

---

## 🐳 Quick Start (Using Docker)

### ✅ Requirements

- [Docker Desktop](https://www.docker.com/products/docker-desktop)

  > For **Windows**:
  - Install the [WSL2 Backend](https://docs.microsoft.com/en-us/windows/wsl/)
  - Use [Git Bash](https://gitforwindows.org/) to run `run.sh` script

  > For **macOS**:
  - Ensure you have **Docker Desktop for Mac** installed
  - Use the built-in **Terminal** app to run shell scripts like `run.sh`

- [Git](https://git-scm.com/)


---

### ▶️ Getting Started

1. **Clone the monorepo:**

```bash
git clone https://github.com/nexuslifeline/seed-core.git
cd seed-core
```

1. **Run the setup script:**

```bash
./run.sh
```

This will:

- Build and start all containers (Laravel backend, React frontend, MySQL)
- Install Laravel dependencies with Composer
- Run database migrations and optional seeders
- Start the Laravel development server
- Start the Vite development server for the frontend

---

### 🔗 Access the App

- **Laravel API**: [http://localhost:8000](http://localhost:8000)  
- **React Frontend**: [http://localhost:5173](http://localhost:5173)  
- **MySQL Database**: `localhost:3307`  
  - Username: `root`  
  - Password: `root`  
  - Database: `seed_invoice`

---

## ⚙️ Manual Setup (Without Docker)

### 🛠 Backend (Laravel)

```bash
cd backend
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

> The Laravel server will be available at http://localhost:8000

### 🛠 Frontend (React + Vite)

```bash
cd frontend
npm install
npm run dev
```

> This will start the Vite development server at `http://localhost:5173`

Make sure the frontend `.env` file is configured correctly. Example:

```env
VITE_API_URL=http://localhost:8000
```


## 📁 Repository Structure

```yaml
seed-core/
├── backend/            # Laravel backend API
│   └── Dockerfile
├── frontend/           # React + Vite frontend
│   └── Dockerfile
├── docker-compose.yml
└── run.sh              # One-click dev setup
```



