<?php
class User {
   protected $ratings = [];

   public function getRatings() { return $this->ratings; }
   public function setRatings($value) { $this->ratings = $value; }

   public function findRatingsByGenre($genreCode) {
       return array_filter($this->ratings, function ($rating) use ($genreCode) {
           return $rating instanceof Rating 
               && $rating->getGame() 
               && $rating->getGame()->getGenreCode() === $genreCode;
       });
   }

   public function getGenreCompatibility($genreCode) {
       $ratings = $this->findRatingsByGenre($genreCode);
       $numRatings = count($ratings);
       if ($numRatings === 0) {
           return null;
       }

       $total = array_reduce($ratings, function($sum, $rating) {
           return $sum + $rating->getScore();
       }, 0);

       return $total / $numRatings;
   }
}
