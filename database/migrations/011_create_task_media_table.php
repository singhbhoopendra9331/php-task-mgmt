<?php

return [

    'up' => [

        "CREATE TABLE task_media (

            id INT AUTO_INCREMENT PRIMARY KEY,

            task_id INT NOT NULL,

            media_id INT NOT NULL,

            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

            UNIQUE KEY unique_task_media (task_id, media_id),

            FOREIGN KEY (task_id)
                REFERENCES tasks(id)
                ON DELETE CASCADE,

            FOREIGN KEY (media_id)
                REFERENCES media(id)
                ON DELETE CASCADE

        )"

    ],

    'down' => [

        "DROP TABLE IF EXISTS task_media"

    ]

];