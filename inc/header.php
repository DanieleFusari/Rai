<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <link rel="shortcut icon" type="image/x-icon" href="/img/ico.ico">
    <link rel="stylesheet" href="/css/normalize.css">
    <link rel="stylesheet" href="/css/header_footer.css">
    <link rel="stylesheet" href=<?= $css ?>>
    <!-- <link href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,700&display=swap" rel="stylesheet"> -->
    <!--
    font-family: 'Amiri', serif;
    Regular 400
    Bold 700
    Bold 700 italic
    -->
    <title><?= $title ?></title>
  </head>
  <body>
    <header>
      <a href="index.php">
        <img tabindex="1" class="logo" src="/img/logo.jpg" alt="logo 3 cats">
      </a>
      <nav>
        <ul class="nav_tabs">
          <li  tabindex="2" class="categorie_tab li">Categories
            <ul class="dropdown">
              <?php
              $categories = categories();
              foreach ($categories as $value) { ?>
                <li class="drop_li"><a href="options.php?cat=<?=$value['categorie_code']; ?>&p=1"><?=$value['categorie_name']?></a></li>
              <?php } ?>
            </ul>
          </li>
          <li class="li" tabindex="3"><a href="code.php">Enter Code</a></li>
          <li class="li" tabindex="4"><a href="favourites.php">Favourites</a></li>
          <li class="li" tabindex="5"><a href="contact.php">Contact</a></li>
        </ul>
      </nav>
    </header>
