<?php

return [

    'up' => [

        "CREATE TABLE users (

            id INT AUTO_INCREMENT PRIMARY KEY,

            role_id INT NOT NULL,

            name VARCHAR(100) NOT NULL,

            email VARCHAR(255) NOT NULL UNIQUE,

            password VARCHAR(255) NOT NULL,

            email_verified_at TIMESTAMP NULL DEFAULT NULL,

            remember_token VARCHAR(100) NULL,

            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

            FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE RESTRICT

        )"

    ],

    'down' => [

        "DROP TABLE IF EXISTS users"

    ]

];