CREATE TABLE migrations (

    id INT AUTO_INCREMENT PRIMARY KEY,

    migration VARCHAR(255),

    batch INT,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

);