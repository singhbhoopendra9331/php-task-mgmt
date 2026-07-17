# Note

```sh
composer init

# composer install

composer install
```

## Frontend (Tailwind CSS + jQuery)

```sh
npm install
npm run build
```

Watch CSS while developing:

```sh
npm run dev
```

## PHP in-built server

```sh
php -S localhost:8000 -t public
```

## Database structure

roles
├── id
├── name
└── description

users
├── id
├── role_id
├── name
├── email
└── password

projects
├── id
├── owner_id
├── name
└── status

project_members
├── id
├── project_id
├── user_id
└── role

tasks
├── id
├── project_id
├── assigned_to
├── created_by
├── title
├── priority
├── status
└── due_date

task_comments
├── id
├── task_id
├── user_id
└── comment

task_attachments
├── id
├── task_id
├── uploaded_by
├── file_name
├── original_name
└── file_path

notifications
├── id
├── user_id
├── title
├── message
├── type
└── is_read

activity_logs
├── id
├── user_id
├── project_id
├── task_id
├── action
├── description
└── created_at