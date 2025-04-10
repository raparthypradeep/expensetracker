<?php
// expense_model.php
require_once 'databaseconnection.php';

class ExpenditureModel {
    private $conn;

    public function __construct() {
        $this->conn = (new DatabaseConnection())->connect();
    }

    public function addExpenditure($amount, $category, $date, $description) {
        //Prepared Statement
        $query = "INSERT INTO expenditure (amount, category, date, description) 
                  VALUES (:amount, :category, :date, :description)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':amount', $amount);
        $stmt->bindParam(':category', $category);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':description', $description);

        return $stmt->execute();
    }

    public function getExpenditure($category = null, $start_date = null, $end_date = null) {
        $query = "SELECT * FROM expenditure WHERE 1=1";

        if ($category) {
            $query .= " AND category = :category";
        }

        if ($start_date && $end_date) {
            $query .= " AND date BETWEEN :start_date AND :end_date";
        }

        // Sorting by date in descending order (newest first)
        $query .= " ORDER BY date DESC";

        $stmt = $this->conn->prepare($query);

        if ($category) {
            $stmt->bindParam(':category', $category);
        }

        if ($start_date && $end_date) {
            $stmt->bindParam(':start_date', $start_date);
            $stmt->bindParam(':end_date', $end_date);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalByCategory() {
        $query = "SELECT category, SUM(amount) as total_spent FROM expenditure GROUP BY category";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
