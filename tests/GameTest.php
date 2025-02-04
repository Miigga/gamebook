<?php
use PHPUnit\Framework\TestCase;

require __DIR__ . "/../src/Entity/Game.php";

class GameTest extends TestCase {
   public function testImage_WithNull_ReturnsPlaceholder()  {
       $game = new Game();
       $game->setImagePath(null);
       $this->assertEquals('images/placeholder.png', $game->getImagePath());
   }
}
