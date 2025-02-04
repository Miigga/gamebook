<?php
require __DIR__ . "/../Entity/Game.php";
require __DIR__ . "/../Entity/Rating.php";

class GameRepository {
   protected $pdo;

   public function __construct() {
       $this->pdo = new PDO('mysql:host=localhost;dbname=gamebook_test', 'root', '');
   }

   public function findByUserId($userId) {
       $query = "SELECT g.id, g.title, g.image_path, g.genre_code 
                 FROM game g 
                 LEFT JOIN rating r ON g.id = r.game_id 
                 WHERE r.user_id = ? OR r.user_id IS NULL";

       $statement = $this->pdo->prepare($query);
       $statement->execute([$userId]);
       $games_array = $statement->fetchAll(PDO::FETCH_ASSOC);

       $games = [];
       foreach ($games_array as $game_array) {
           $game = new Game($game_array['id']);
           $game->setTitle($game_array['title']);
           $game->setImagePath($game_array['image_path']);
           $game->setGenreCode($game_array['genre_code']);

           // Fetch Ratings
           $rating = new Rating();
           $rating->setScore(4.5); // Placeholder score for now
           $game->setRatings([$rating]);

           $games[] = $game;
       }

       return $games;
   }
}
