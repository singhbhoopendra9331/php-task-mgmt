<?php

return [

    'up' => [

        "CREATE TABLE notifications (

            id INT AUTO_INCREMENT PRIMARY KEY,

            user_id INT NOT NULL,

            title VARCHAR(255) NOT NULL,

            message TEXT NOT NULL,

            type ENUM(
                'task_assigned',
                'task_updated',
                'task_completed',
                'project_created',
                'system'
            ) DEFAULT 'system',

            is_read BOOLEAN DEFAULT FALSE,

            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

            FOREIGN KEY (user_id) REFERENCES users(id)
                ON DELETE CASCADE

        )"

    ],

    'down' => [

        "DROP TABLE IF EXISTS notifications"

    ]

];