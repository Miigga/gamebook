<?php
class User {
   protected $ratings;

   public function getRatings() { return $this->ratings; }
   public function setRatings($value) { $this->ratings = $value; }

   public function findRatingsByGenre($genreCode) {
       return array_filter($this->getRatings(), fn($rating) => $rating->getGame()->getGenreCode() == $genreCode);
   }

   public function getGenreCompatibility($genreCode) {
       $ratings = $this->findRatingsByGenre($genreCode);
       return count($ratings) ? array_sum(array_map(fn($r) => $r->getScore(), $ratings)) / count($ratings) : null;
   }
}
