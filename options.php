<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('html_errors', 1);


$categorie = filter_input(INPUT_GET, 'cat', FILTER_SANITIZE_STRING);
$off = filter_input(INPUT_GET, 'off', FILTER_SANITIZE_NUMBER_INT);
$p = filter_input(INPUT_GET, 'p', FILTER_SANITIZE_NUMBER_INT);
$sub_categorie_selected = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
unset($sub_categorie_selected['cat']);
unset($sub_categorie_selected['p']);
unset($sub_categorie_selected['off']);

if (empty($p)) {
  $p = 0;
}

if (empty($categorie)) {
  header("Location: /");
}

if (empty($off)) {
  $off = 0;
};

$css = '/css/options.css';
$js = '/js/options.js';
include 'controllers/functions.php';

$categorie_name = categorie_name($categorie);
$categorie_name = $categorie_name['categorie_name'];

if ($categorie_name == Null) {
    header("Location: /");
}

$title = "Categorie $categorie_name";
include 'inc/header.php';

if ($sub_categorie_selected) {
    $cards = code_sub_cat_search_word($categorie, $off, $sub_categorie_selected);
    $items = amount_categories();
  } else {
    $cards = code_sub_cat($categorie, $off);
    $sub_categorie_selected = [];
    $items = total_code_sub_cat($categorie, $off);
}
$sub_categorie = sort_subcats($categorie);

?>

<main>
  <img class="burger_menu" src="/img/hamburger-button.png" alt="hamburger menu button">
  <h1 class="header"><?=$categorie_name?></h1>
  <div class="pages">
    <!-- Page numbers clases are
    class="on_page" & class="off_page"-->
    <?php pages();?>
  </div>
  <aside class="side_bar">
    <div class="close_side_bar">X</div>
    <h3>Options</h3>
    <form class="tick_box_form" action="options.php" method="get">
      <input hidden type="text" name="cat" value="<?=$categorie?>">
      <input hidden type="text" name="p" value="1">
      <table>
        <?php foreach ($sub_categorie as $value): ?>
          <tr>
            <th>
              <label for="tick_<?=$value?>"><?=ucwords($value)?></label>
            </th>
            <td>
              <input <?php if (in_array($value, $sub_categorie_selected)) echo 'checked' ?> id="tick_<?=$value?>" type="checkbox" name="t_<?=$value?>" value="<?=$value?>">
            </td>
          </tr>
        <?php endforeach; ?>
      </table>
      <input type="submit" value="UPDATE">
    </form>
  </aside>


  <div class="all_cards">
    <?php foreach ($cards as $value): ?>
      <div class="card">
        <a href="details?code=<?=$value['code']?>"><img class="card_img" src="/card_img/<?=$value['code']?>.jpg" alt=""></a>
        <p class="card_code"><?=$value['code']?></p>
      </div>
    <?php endforeach; ?>
  </div>
  <div class="pages">
    <!-- Page numbers clases are
    class="on_page" & class="off_page"-->
    <?php pages();?>
  </div>
</main>

<?php include 'inc/footer.php'; ?>
