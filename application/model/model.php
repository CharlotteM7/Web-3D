<?php
class Model {
    private $dbPath;

    public function __construct() {
        // Adjust this path so it points at your test.db
        $this->dbPath = __DIR__ . '/../../db/test.db';
    }

    /** 
     * Return an array of all distinct brand names 
     */
    public function getBrands(): array {
        $pdo = new PDO('sqlite:' . $this->dbPath);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $pdo->query("SELECT DISTINCT brand FROM drinks");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}
