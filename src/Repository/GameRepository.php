<?php
require __DIR__ . "/../Entity/Game.php";
require __DIR__ . "/../Entity/Rating.php";

class GameRepository {
   protected $pdo;

   public function __construct() {
       $this->pdo = new PDO('mysql:host=localhost;dbname=gamebook_test', 'root', null);
   }

   public function findById($id) {
       $stmt = $this->pdo->prepare('SELECT * FROM game WHERE id = ?');
       $stmt->execute([$id]);
       return $stmt->fetchObject('Game');
   }

   public function saveGameRating($gameId, $userId, $score) {
       $stmt = $this->pdo->prepare('REPLACE INTO rating (game_id, user_id, score) VALUES(?, ?, ?)');
       return $stmt->execute([$gameId, $userId, $score]);
   }

   public function findByUserId($id) {
       $stmt = $this->pdo->prepare('SELECT * FROM game');
       $stmt->execute();
       return $stmt->fetchAll(PDO::FETCH_CLASS, 'Game');
   }
}
