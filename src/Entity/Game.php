<?php
class Game {
   protected $title;
   protected $imagePath;
   protected $ratings;
   protected $id;
   protected $genreCode;

   public function __construct($id = null)  {
       $this->id = $id;
   }
   public function getId() { return $this->id; }
   public function getGenreCode() { return $this->genreCode; }
   public function setGenreCode($value) { $this->genreCode = $value; }
   public function getTitle() { return $this->title; }
   public function setTitle($value) { $this->title = $value; }
   public function getImagePath() { return $this->imagePath ?: 'images/placeholder.png'; }
   public function setImagePath($value) { $this->imagePath = $value; }
   public function getRatings() { return $this->ratings; }
   public function setRatings($value) { $this->ratings = $value; }

   public function getAverageScore() {
       $ratings = $this->getRatings();
       $numRatings = count($ratings);
       if ($numRatings == 0) return null;

       $total = 0;
       foreach ($ratings as $rating) {
           $score = $rating->getScore();
           if ($score !== null) $total += $score;
       }
       return $total / $numRatings;
   }
}
