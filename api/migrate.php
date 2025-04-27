<?php
require 'config.php';

try {
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS clients (
            id SERIAL PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            age INTEGER NOT NULL CHECK (age > 0),
            gender VARCHAR(10) CHECK (gender IN ('Male', 'Female')),
            contact_info VARCHAR(255) NOT NULL,
            image_name VARCHAR(255) NOT NULL DEFAULT ''
        );
        
        CREATE TABLE IF NOT EXISTS programs (
            id SERIAL PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            description TEXT NOT NULL,
            duration INTEGER NOT NULL,
            start_date DATE NOT NULL DEFAULT CURRENT_DATE
        );
        
        CREATE TABLE IF NOT EXISTS client_programs (
            client_id INTEGER REFERENCES clients(id) ON DELETE CASCADE,
            program_id INTEGER REFERENCES programs(id) ON DELETE CASCADE,
            enrollment_date DATE DEFAULT CURRENT_DATE,
            PRIMARY KEY (client_id, program_id)
        );
    ");
    
    // Insert sample data (optional)
    $pdo->exec("
        INSERT INTO clients (name, age, gender, contact_info) VALUES
        ('Abigail Nguli', 22, 'Female', '+254712345678'),
        ('Brian Mwenda', 24, 'Male', '254767896452')
        ON CONFLICT DO NOTHING;
        
        INSERT INTO programs (id, name, description, duration, start_date) VALUES
        (5, 'HIV', 'How often should you go for testing?', 30, '2025-04-27'),
        (15, 'Malaria', 'Who does it mostly affect?', 90, '2025-04-27')
        ON CONFLICT (id) DO UPDATE SET
            name = EXCLUDED.name,
            description = EXCLUDED.description,
            duration = EXCLUDED.duration,
            start_date = EXCLUDED.start_date;
    ");
    
    echo "Database schema created and sample data inserted successfully!";
} catch (PDOException $e) {
    die("Migration failed: " . $e->getMessage());
}