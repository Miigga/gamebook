<?php
class Game {
   protected $id;
   protected $title;
   protected $imagePath;
   protected $ratings = [];
   protected $genreCode;

   public function __construct($id = null) {
       $this->id = $id;
   }

   public function getId() { return $this->id; }
   public function getTitle() { return $this->title; }
   public function setTitle($value) { $this->title = $value; }

   public function getImagePath() {
       return !empty($this->imagePath) ? $this->imagePath : 'images/placeholder.png';
   }
   public function setImagePath($value) { $this->imagePath = $value; }

   public function getGenreCode() { return $this->genreCode; }
   public function setGenreCode($value) { $this->genreCode = $value; }

   public function getRatings() { return $this->ratings; }
   public function setRatings($value) { $this->ratings = $value; }

   public function getAverageScore() {
       $ratings = array_filter($this->getRatings(), function($rating) {
           return $rating->getScore() !== null;
       });

       if (empty($ratings)) {
           return null;
       }

       $total = array_reduce($ratings, function($sum, $rating) {
           return $sum + $rating->getScore();
       }, 0);

       return $total / count($ratings);
   }

   public function isRecommended($user) {
       $averageScore = $this->getAverageScore();
       
       if ($averageScore === null) {
           return false; // Ensures it does not return null
       }

       $compatibility = $user->getGenreCompatibility($this->getGenreCode());

       if ($compatibility === null) {
           return false;
       }

       return ($averageScore / 10) * $compatibility >= 3;
   }
}
