<?php

return [

    'up' => [

        "CREATE TABLE project_members (

            id INT AUTO_INCREMENT PRIMARY KEY,

            project_id INT NOT NULL,

            user_id INT NOT NULL,

            role ENUM('owner','manager','member')
                DEFAULT 'member',

            joined_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

            UNIQUE(project_id, user_id),

            FOREIGN KEY (project_id) REFERENCES projects(id)
                ON DELETE CASCADE,

            FOREIGN KEY (user_id) REFERENCES users(id)
                ON DELETE CASCADE

        )"

    ],

    'down' => [

        "DROP TABLE IF EXISTS project_members"

    ]

];