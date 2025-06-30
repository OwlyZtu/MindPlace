# 🧠 MindPlace

**MindPlace** is a mental health support platform designed to connect users with licensed psychologists and psychotherapists. The system provides tools for both users and specialists to interact through profile management, secure communication, and therapeutic resources.

## 🚀 Features

- 🧍‍♂️ User registration, authentication, and personal dashboard  
- 🧑‍⚕️ Specialist onboarding with document verification and profile setup  
- 🔐 Role-based access (Admin, Specialist, User)  
- 📝 Application management for specialist review by admins  
- 📄 Session notes and therapy records
- ✍️ Doctors can public their articles about mental  health
- ☁️ Integration with AWS S3 for secure document storage  
- 🌐 Adaptive interface for desktop and mobile
  
## 👥 Roles
Admin: full access to manage users and specialists, articles

Specialist: manage their profile and clients, CRUD own articles

User: access mental health support

## 🛠️ Tech Stack

- **Backend**: PHP 8.1, Yii2 Framework  
- **Frontend**: HTML5, Bootstrap5, JS  
- **Database**: MySQL  
- **Containerization**: Docker, Docker Compose  
- **Cloud Storage**: Amazon S3  
- **Authentication**: RBAC with IdentityInterface  
- **Dev Tools**: Git, Composer, ESLint

## 📦 Installation

### Prerequisites

- Docker & Docker Compose installed  
- Composer installed locally (for host-side commands)

### Setup Instructions

```bash
# Clone the repository
git clone https://github.com/OwlyZtu/MindPlace.git
cd MindPlace

# Start the containers
docker-compose up -d --build

# Enter the PHP container and install dependencies
docker-compose exec php composer install

# Apply DB migrations
docker-compose exec php yii migrate

# Set correct permissions (if needed)
chmod -R 775 runtime web/assets
```
## Environment Configuration
Rename .env.example to .env and configure your environment variables, especially:

DB_DSN=mysql:host=db;dbname=mindplace
DB_USERNAME=root
DB_PASSWORD=yourpassword

AWS_BUCKET_NAME=your-bucket
AWS_ACCESS_KEY_ID=your-access-key
AWS_SECRET_ACCESS_KEY=your-secret-key
