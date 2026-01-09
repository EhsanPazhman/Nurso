# 🩺 Nurso | Clinical Monitoring System

<!-- <p align="center">
    <img src="raw.githubusercontent.com" width="200" alt="">
</p> -->

## 🌟 About Nurso
**Nurso** is a modern, lightweight, and mobile-first clinical management system designed to empower nurses and healthcare providers. Born from a nursing background, this project aims to bridge the gap between healthcare expertise and modern web technology.

It replaces traditional paper-based charting with a real-time digital solution for tracking patient vitals and nursing handovers, specifically optimized for high-pressure medical environments.

## 🚀 Key Features (Phase 1)
- **Patient Management:** Comprehensive digital records for admitted patients.
- **Vitals Tracking:** Real-time logging of Heart Rate, Blood Pressure, SPO2, and Temperature.
- **Smart Alerts:** Instant visual feedback for critical vital signs.
- **Shift Handover:** Digital reporting to ensure seamless continuity of care.

## 🛠️ Technical Stack
- **Framework:** [Laravel 12](https://laravel.com) (Latest Stable)
- **Frontend:** [Livewire v3](https://livewire.laravel.com) (Reactive UI)
- **Styling:** [Tailwind CSS](https://tailwindcss.com)
- **Database:** MySQL

## ⚙️ Installation
1. **Clone the repository:**
   ```bash
   git clone github.com
2. **Install dependencies:**
   ```bash
   composer install
3. **Setup environment:**
   ```bash
   cp .env.example .env
   php artisan key:generate
4. **Run migrations:**
   ```bash
   php artisan migrate
5. **Start development server:**
   ```bash
   php artisan serve

---

## 📊 Database Schema
The system utilizes a structured relational database:
Patients: Stores identity, bed numbers, and admission status.
Vitals: Stores time-stamped clinical data linked to patients.

---

## 👨‍💻 Author
Developed by **Ehsanullah Pazhman**  
📧 Email: ehsanpazhman@gmail.com  
Focusing on building technology that saves time and lives in the healthcare sector.

---

## License
This project is licensed under the **MIT License** – free to use, modify, and distribute.



