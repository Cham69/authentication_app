<?php
class User {
    private $db;

    public function __construct() {
        require 'config/database.php';
        $this->db = $conn;
    }

    public function store($firstName, $lastName, $email, $password, $otp) {
        $now = date('Y-m-d H:i:s');
        $expiryDate = new DateTime();
        $expiryDate->modify('+30 days');
        $expiryDate = $expiryDate->format('Y-m-d H:i:s');
        
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("
                    INSERT INTO au_users (
                        first_name, last_name, email, password, verification_code, created_at, password_expiry_date
                        ) 
                        VALUES (?, ?, ?, ?, ?, ?, ?)"
                    );
        
        $success = $stmt->execute([
            $firstName, $lastName, $email, $hashedPassword, $otp,
            $now, $expiryDate
        ]);

        $lastInsertId = $this->db->lastInsertId();

        $updateStmt = $this->db->prepare("UPDATE au_users SET created_by = ? WHERE id = ?");
        $updateStmt->execute([$lastInsertId, $lastInsertId]);
    
        if (!$success) {
            print_r($stmt->errorInfo());
            return false;
        }
    
        return true;
    }

    public function getUserByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM au_users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function authenticate($email, $password) {
        $stmt = $this->db->prepare("SELECT * FROM au_users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }

        return false;
    }
}
