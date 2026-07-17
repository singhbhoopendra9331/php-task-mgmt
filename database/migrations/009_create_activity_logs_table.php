<?php

return [

    'up' => [

        "CREATE TABLE activity_logs (

            id INT AUTO_INCREMENT PRIMARY KEY,

            user_id INT NOT NULL,

            project_id INT NULL,

            task_id INT NULL,

            action VARCHAR(100) NOT NULL,

            description TEXT NULL,

            ip_address VARCHAR(45) NULL,

            user_agent TEXT NULL,

            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

            FOREIGN KEY (user_id) REFERENCES users(id)
                ON DELETE CASCADE,

            FOREIGN KEY (project_id) REFERENCES projects(id)
                ON DELETE SET NULL,

            FOREIGN KEY (task_id) REFERENCES tasks(id)
                ON DELETE SET NULL

        )"

    ],

    'down' => [

        "DROP TABLE IF EXISTS activity_logs"

    ]

];