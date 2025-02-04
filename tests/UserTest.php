<?php
use PHPUnit\Framework\TestCase;

require __DIR__ . "/../src/Entity/Game.php";
require __DIR__ . "/../src/Entity/Rating.php";
require __DIR__ . "/../src/Entity/User.php";

class UserTest extends TestCase {
   public function testGenreCompatibility_With8And6_Returns7() {
       $rating1 = $this->createMock(Rating::class);
       $rating1->method('getScore')->willReturn(6);

       $rating2 = $this->createMock(Rating::class);
       $rating2->method('getScore')->willReturn(8);

       $user = $this->getMockBuilder(User::class)
           ->setMethods(['findRatingsByGenre'])
           ->getMock();
       $user->method('findRatingsByGenre')->willReturn([$rating1, $rating2]);

       $this->assertEquals(7, $user->getGenreCompatibility('zombies'));
   }

   public function testRatingsByGenre_With1ZombieAnd1Shooter_Returns1Zombie() {
       $rating1 = $this->createMock(Rating::class);
       $rating1->method('getScore')->willReturn(5);
       $game1 = $this->createMock(Game::class);
       $game1->method('getGenreCode')->willReturn('zombies');
       $rating1->method('getGame')->willReturn($game1);

       $rating2 = $this->createMock(Rating::class);
       $rating2->method('getScore')->willReturn(4);
       $game2 = $this->createMock(Game::class);
       $game2->method('getGenreCode')->willReturn('shooter');
       $rating2->method('getGame')->willReturn($game2);

       $user = new User();
       $user->setRatings([$rating1, $rating2]);

       $filteredRatings = $user->findRatingsByGenre('zombies');

       $this->assertCount(1, $filteredRatings, "Expected only one zombie-rated game rating.");
   }
}
