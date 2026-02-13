<?php
// Initialize SQLite database with tables and data
try {
    $pdo = new PDO('sqlite:' . __DIR__ . '/misc.db');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create users table
    $pdo->exec("CREATE TABLE IF NOT EXISTS users (
        user_id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT,
        email TEXT,
        password TEXT
    )");
    
    // Create Profile table
    $pdo->exec("CREATE TABLE IF NOT EXISTS Profile (
        profile_id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id INTEGER NOT NULL,
        first_name TEXT,
        last_name TEXT,
        email TEXT,
        headline TEXT,
        summary TEXT,
        FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
    )");
    
    // Insert default user if not exists
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
    $stmt->execute(['umsi@umich.edu']);
    $count = $stmt->fetchColumn();
    
    if ($count == 0) {
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->execute(['UMSI', 'umsi@umich.edu', '1a52e17fa899cf40fb04cfc42e6352f1']);
    }
    
    echo "Base de données initialisée avec succès!";
} catch (PDOException $e) {
    die('Erreur: ' . $e->getMessage());
}
?>
