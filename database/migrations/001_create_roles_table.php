<?php

return [

    'up' => [

        "CREATE TABLE roles (

            id INT AUTO_INCREMENT PRIMARY KEY,

            name VARCHAR(50) NOT NULL UNIQUE,

            description VARCHAR(255) NULL,

            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP

        )",

        "INSERT INTO roles (name, description) VALUES
            ('Admin', 'System Administrator'),
            ('Manager', 'Project Manager'),
            ('Employee', 'Regular Employee')"

    ],

    'down' => [

        "DROP TABLE IF EXISTS roles"

    ]

];