<?php

return [

    'up' => [

        "CREATE TABLE tasks (

            id INT AUTO_INCREMENT PRIMARY KEY,

            project_id INT NOT NULL,

            assigned_to INT NULL,

            created_by INT NOT NULL,

            title VARCHAR(255) NOT NULL,

            description TEXT NULL,

            priority ENUM('low','medium','high','urgent')
                DEFAULT 'medium',

            status ENUM(
                'todo',
                'in_progress',
                'review',
                'completed'
            ) DEFAULT 'todo',

            due_date DATE NULL,

            completed_at TIMESTAMP NULL DEFAULT NULL,

            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                ON UPDATE CURRENT_TIMESTAMP,

            FOREIGN KEY (project_id) REFERENCES projects(id)
                ON DELETE CASCADE,

            FOREIGN KEY (assigned_to) REFERENCES users(id)
                ON DELETE SET NULL,

            FOREIGN KEY (created_by) REFERENCES users(id)
                ON DELETE CASCADE

        )"

    ],

    'down' => [

        "DROP TABLE IF EXISTS tasks"

    ]

];