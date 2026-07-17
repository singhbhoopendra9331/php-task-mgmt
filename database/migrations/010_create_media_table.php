<?php

return [

    'up' => [

        "CREATE TABLE media (

            id INT AUTO_INCREMENT PRIMARY KEY,

            uploaded_by INT NOT NULL,

            original_name VARCHAR(255) NOT NULL,

            file_name VARCHAR(255) NOT NULL,

            file_path VARCHAR(500) NOT NULL,

            mime_type VARCHAR(100) NOT NULL,

            extension VARCHAR(20) NOT NULL,

            file_size BIGINT NOT NULL,

            alt_text VARCHAR(255) NULL,

            caption TEXT NULL,

            description TEXT NULL,

            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                ON UPDATE CURRENT_TIMESTAMP,

            FOREIGN KEY (uploaded_by) REFERENCES users(id)
                ON DELETE CASCADE
        )"

    ],

    'down' => [

        "DROP TABLE IF EXISTS media"

    ]

];