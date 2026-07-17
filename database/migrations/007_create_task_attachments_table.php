<?php

return [

    'up' => [

        "CREATE TABLE task_attachments (

            id INT AUTO_INCREMENT PRIMARY KEY,

            task_id INT NOT NULL,

            uploaded_by INT NOT NULL,

            file_name VARCHAR(255) NOT NULL,

            original_name VARCHAR(255) NOT NULL,

            file_path VARCHAR(500) NOT NULL,

            file_size BIGINT NOT NULL,

            mime_type VARCHAR(100) NOT NULL,

            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

            FOREIGN KEY (task_id) REFERENCES tasks(id)
                ON DELETE CASCADE,

            FOREIGN KEY (uploaded_by) REFERENCES users(id)
                ON DELETE CASCADE

        )"

    ],

    'down' => [

        "DROP TABLE IF EXISTS task_attachments"

    ]

];