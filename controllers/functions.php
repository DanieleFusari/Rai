<?php

try {
  $db = new PDO('sqlite:' . __DIR__ . '/database.db');
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (\Exception $e) {
  echo $e->getMessage();
}

function categories() {
  global $db;
  $results = $db->query('SELECT * FROM categories');
  $results = $results->fetchAll(PDO::FETCH_ASSOC);
  return $results;
}

function amount_categories() {
  global $db;
  global $limit;
  global $sub_categorie_selected;
  global $categorie;

  $sql = "SELECT count(*) AS amount FROM cards WHERE categorie_code = '$categorie' AND ";
  $keyCount = 0;
  foreach ($sub_categorie_selected as $value) {
    if ($keyCount > 0) {
      $sql .= " OR";
    }
    $sql .= " sub_categorie LIKE '%$value%'";
    ++$keyCount;
  }
  $results = $db->query($sql);
  $results = $results->fetch(PDO::FETCH_ASSOC);
  return $results;
}

$limit = 12;

function pages() {
  global $limit;
  global $categorie;
  global $p;
  global $off;
  global $sub_categorie_selected;
  global $items;
  $items_per_page = ceil($items['amount'] / $limit);
  echo 'Pages ';
  for ($i=1; $i <= $items_per_page; $i++) {
    if ($i == $p) {
      echo '<span class="on_page">' . $i . ', </span>';
    } else {
      $all_cats = '';
      foreach ($sub_categorie_selected as $value) {
         $all_cats .= '&' . "t_" . $value .'=' . $value;
      };
      echo '<span class="off_page"><a href="options.php?cat=' . $categorie . $all_cats . '&' . 'off=' .  ($i -1) * $limit . '&' . 'p=' .  $i . '">' . $i . ', </a></span>';
    }
  }
}

function categorie_name($cat) {
  global $db;
  $results = $db->prepare('SELECT * FROM categories WHERE categories.categorie_code = :cat');
  $results->bindParam(":cat", $cat);
  $results->execute();
  $results = $results->fetch(PDO::FETCH_ASSOC);
  return $results;
}

function code_sub_cat($cat, $offset) {
  global $db;
  global $limit;
  $results = $db->prepare("SELECT code, sub_categorie FROM cards WHERE cards.categorie_code = :cat LIMIT :lim OFFSET :off");
  $results->bindParam(":cat", $cat);
  $results->bindParam(":lim", $limit);
  $results->bindParam(":off", $offset);
  $results->execute();
  $results = $results->fetchAll(PDO::FETCH_ASSOC);
  return $results;
}

function total_code_sub_cat($cat) {
  global $db;
  global $limit;
  $results = $db->prepare("SELECT count(*) AS amount FROM cards WHERE cards.categorie_code = :cat");
  $results->bindParam(":cat", $cat);
  $results->execute();
  $results = $results->fetch(PDO::FETCH_ASSOC);
  return $results;
}

function sort_subcats($categorie){
  $options = code_sub_cat($categorie, 0);
  $sub = [];
  foreach ($options as $value) {
    $sub_categorie =  explode(',', strtolower($value['sub_categorie']));
    foreach ($sub_categorie as $value) {
      $value = trim($value);
      array_push($sub, $value);
    }
  }
  $sub_categorie = array_unique($sub);
  return array_values($sub_categorie);
}

function code_sub_cat_search_word($cat, $offset, $search_words) {
  $sql = "SELECT code, sub_categorie FROM cards WHERE categorie_code = :cat  AND ";
  // $keywords = explode(" ", $search_words);
  $keyCount = 0;
  foreach ($search_words as $value) {
    if ($keyCount > 0) {
      $sql .= " OR";
    }
    $sql .= " sub_categorie LIKE '%$value%'";
    ++$keyCount;
  }
  $sql .= " LIMIT :lim OFFSET :off";
  global $db;
  global $limit;
  $results = $db->prepare($sql);
  $results->bindParam(":cat", $cat);
  $results->bindParam(":lim", $limit);
  $results->bindParam(":off", $offset);
  $results->execute();
  $results = $results->fetchAll(PDO::FETCH_ASSOC);
  return $results;
}

function categorie($cat) {
  global $db;
  $results = $db->prepare("SELECT * FROM cards JOIN categories ON cards.categorie_code = categories.categorie_code WHERE cards.categorie_code = :cat");
  $results->bindParam(":cat", $cat);
  $results->execute();
  $results = $results->fetchAll(PDO::FETCH_ASSOC);
  return $results;
}

// functions for details page

function getcard($card_code){
  global $db;
  $results = $db->prepare('SELECT * FROM cards WHERE code = :code');
  $results->bindParam(":code", $card_code);
  $results->execute();
  $results = $results->fetch(PDO::FETCH_ASSOC);
  return $results;
}


 // favourites function
function fav_list($sql){
  global $db;
  $results = $db->query($sql);
  $results = $results->fetchAll(PDO::FETCH_ASSOC);
  return $results;

}
