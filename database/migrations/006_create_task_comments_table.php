<?php

return [

    'up' => [

        "CREATE TABLE task_comments (

            id INT AUTO_INCREMENT PRIMARY KEY,

            task_id INT NOT NULL,

            user_id INT NOT NULL,

            comment TEXT NOT NULL,

            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                ON UPDATE CURRENT_TIMESTAMP,

            FOREIGN KEY (task_id) REFERENCES tasks(id)
                ON DELETE CASCADE,

            FOREIGN KEY (user_id) REFERENCES users(id)
                ON DELETE CASCADE

        )"

    ],

    'down' => [

        "DROP TABLE IF EXISTS task_comments"

    ]

];