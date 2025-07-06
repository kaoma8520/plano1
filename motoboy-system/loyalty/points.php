<?php
session_start();
require_once '../config/database.php';

class LoyaltyPoints {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function addPoints($clientId, $points) {
        $query = "UPDATE clients SET points = points + :points WHERE id = :clientId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':points', $points);
        $stmt->bindParam(':clientId', $clientId);
        return $stmt->execute();
    }

    public function redeemPoints($clientId, $points) {
        $query = "UPDATE clients SET points = points - :points WHERE id = :clientId AND points >= :points";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':points', $points);
        $stmt->bindParam(':clientId', $clientId);
        return $stmt->execute() && $stmt->rowCount() > 0;
    }

    public function getPoints($clientId) {
        $query = "SELECT points FROM clients WHERE id = :clientId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':clientId', $clientId);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
}

$db = new Database();
$loyaltyPoints = new LoyaltyPoints($db->getConnection());
?>