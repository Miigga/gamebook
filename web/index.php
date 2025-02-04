<?php
require __DIR__ . "/../src/Repository/GameRepository.php";

$repo = new GameRepository();
$games = $repo->findByUserId(1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gamebook Ratings</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h1 { text-align: center; }
        .game-list { display: flex; flex-direction: column; align-items: center; width: 100%; }
        .game-item { display: flex; align-items: center; border-bottom: 1px solid #ccc; padding: 10px; width: 60%; }
        .game-item img { width: 100px; height: 100px; margin-right: 15px; }
        .game-details { display: flex; flex-direction: column; }
    </style>
</head>
<body>

<h1>Gamebook Ratings</h1>
<div class="game-list">
    <?php foreach ($games as $game): ?>
        <div class="game-item">
            <img src="<?php echo $game->getImagePath(); ?>" alt="<?php echo $game->getTitle(); ?>">
            <div class="game-details">
                <strong><?php echo $game->getTitle(); ?></strong>
                <a href="add-rating.php?game=<?php echo $game->getId(); ?>">Rate</a>
                <span>Average Score: <?php echo $game->getAverageScore() ?? 'No Ratings Yet'; ?></span>
            </div>
        </div>
    <?php endforeach; ?>
</div>

</body>
</html>
