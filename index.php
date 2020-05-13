<?php
$title = 'Rai Studio\'s';
$css = 'css/home.css';
include 'controllers/functions.php';
include 'inc/header.php';
?>
    <main>
      <h1>Rai's Studio</h1>
      <ul class="mobile_card_topics">
        <?php
        $categories = categories();
        $num = 0;
        foreach ($categories as $value) { ?>
          <li><a tabindex="<?=$num;?>" href="options.php?cat=<?=$value['categorie_code'];?>&p=1" > <?= $value['categorie_name'] ?></a></li>
        <?php $num++;} ?>
        <li><a href="code.php">Find Code</a></li>
        <li><a href="favourites.php">Favourites</a></li>
        <li><a href="contact.php">Contact</a></li>
      </ul>
    </main>

  </body>
</html>
