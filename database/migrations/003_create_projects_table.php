<?php

return [

    'up' => [

        "CREATE TABLE projects (

            id INT AUTO_INCREMENT PRIMARY KEY,

            name VARCHAR(150) NOT NULL,

            description TEXT NULL,

            status ENUM('planning','active','completed','archived')
                DEFAULT 'planning',

            start_date DATE NULL,

            end_date DATE NULL,

            owner_id INT NOT NULL,

            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                ON UPDATE CURRENT_TIMESTAMP,

            FOREIGN KEY (owner_id) REFERENCES users(id)
                ON DELETE CASCADE

        )"

    ],

    'down' => [

        "DROP TABLE IF EXISTS projects"

    ]

];