<?php
use PHPUnit\Framework\TestCase;

require __DIR__ . "/../src/Entity/Game.php";
require __DIR__ . "/../src/Entity/Rating.php";
require __DIR__ . "/../src/Entity/User.php";

class GameTest extends TestCase {
   public function testImage_WithNull_ReturnsPlaceholder() {
       $game = new Game();
       $game->setImagePath(null);
       $this->assertEquals('images/placeholder.png', $game->getImagePath());
   }

   public function testImage_WithPath_ReturnsPath() {
       $game = new Game();
       $game->setImagePath("images/custom-game.png");
       $this->assertEquals("images/custom-game.png", $game->getImagePath());
   }

   public function testAverageScore_WithoutRatings_ReturnsNull() {
       $game = new Game();
       $game->setRatings([]);
       $this->assertNull($game->getAverageScore());
   }

   public function testAverageScore_With6And8_Returns7() {
       $rating1 = $this->createMock(Rating::class);
       $rating1->method('getScore')->willReturn(6);

       $rating2 = $this->createMock(Rating::class);
       $rating2->method('getScore')->willReturn(8);

       $game = $this->getMockBuilder(Game::class)
           ->setMethods(['getRatings'])
           ->getMock();
       $game->method('getRatings')->willReturn([$rating1, $rating2]);

       $this->assertEquals(7, $game->getAverageScore());
   }

   public function testIsRecommended_WithCompatibility2AndScore10_ReturnsFalse() {
       $game = $this->getMockBuilder(Game::class)
           ->setMethods(['getAverageScore'])
           ->getMock();
       $game->method('getAverageScore')->willReturn(10); // Ensures valid score

       $user = $this->getMockBuilder(User::class)
           ->setMethods(['getGenreCompatibility'])
           ->getMock();
       $user->method('getGenreCompatibility')->willReturn(2);

       $this->assertFalse($game->isRecommended($user));
   }

   public function testIsRecommended_WithCompatibility10AndScore10_ReturnsTrue() {
       $game = $this->getMockBuilder(Game::class)
           ->setMethods(['getAverageScore'])
           ->getMock();
       $game->method('getAverageScore')->willReturn(10); // Ensures valid score

       $user = $this->getMockBuilder(User::class)
           ->setMethods(['getGenreCompatibility'])
           ->getMock();
       $user->method('getGenreCompatibility')->willReturn(10);

       $this->assertTrue($game->isRecommended($user));
   }
}
