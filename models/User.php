<?php
class User {
    private $db;

    public function __construct() {
        require 'config/database.php';
        $this->db = $conn;
    }

    public function store($firstName, $lastName, $email, $password) {
        $now = date('Y-m-d H:i:s');
        $expiryDate = new DateTime();
        $expiryDate->modify('+30 days');
        $expiryDate = $expiryDate->format('Y-m-d H:i:s');
        
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("
                    INSERT INTO au_users (
                        first_name, last_name, email, password, created_at, password_expiry_date
                        ) 
                        VALUES (?, ?, ?, ?, ?, ?)"
                    );
        
        $success = $stmt->execute([
            $firstName, $lastName, $email, $hashedPassword,
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

    public function setOtp($email, $otp) {
        $stmt = $this->db->prepare("UPDATE au_users SET verification_code = ?, has_sent_code = ? WHERE email = ?");
        return $stmt->execute([$otp, 1, $email]);
    }

    public function verifyUser($email) {
        $stmt = $this->db->prepare("UPDATE au_users SET status = 1 WHERE email = ?");
        return $stmt->execute([$email]);
    }

    public function setResetToken($id, $email, $token, $expiryDate) {
        $now = date('Y-m-d H:i:s');
        $stmt = $this->db->prepare("INSERT INTO au_password_resets (user_id, token, expiry_at, sent_at) VALUES (?, ?, ?, ?) ");
        return $stmt->execute([$id, $token, $expiryDate, $now]);
    }
}
