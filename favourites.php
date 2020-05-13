<?php
$css = '/css/options.css';
$js = '/js/favourites.js';
include 'controllers/functions.php';
$title = "Your Favourites";
include 'inc/header.php';
session_start();

if (isset($_SESSION['fav'])) {
  $list = explode(', ', $_SESSION['fav']);
  array_pop($list);
  $num = count($list);
  $i = 0;
  $sql = 'SELECT code FROM cards WHERE code IN(';
  foreach ($list as $value) {
      if(++$i === $num) {
      $sql .= '\'' . $value . '\'';
    } else {
      $sql .= '\'' . $value . '\',';
    }
  }
  $sql .= ');';
  $fav_list = fav_list($sql);
}
?>
<main>
  <?php if (isset($_SESSION['fav']) && !empty($fav_list)){ ?>
    <a class="clear_all" href="controllers/favourites.php">Clear All</a>
    <div class="all_cards">
      <?php foreach ($fav_list as $value): ?>
        <div class="card">
          <a href="details.php?code=<?=$value['code']?>"><img class="card_img" src="/card_img/<?=$value['code']?>.jpg" alt=""></a>
          <p class="card_code"><?=$value['code']?></p>
        </div>
      <?php endforeach; ?>
    </div>
  <?php } else { ?>
    <p>No favourites</p>
  <?php } ?>
</main>

<?php  include 'inc/footer.php';?>
