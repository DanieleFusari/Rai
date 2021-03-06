<?php
$code = filter_input(INPUT_GET, 'code', FILTER_SANITIZE_STRING);
$code = ucwords($code);
$css = '/css/details.css';
$js = '/js/details.js';
include 'controllers/functions.php';
$title = "Code $code";
include 'inc/header.php';
$card_details = getcard($code);
session_start();

if(isset($_SESSION['fav'])){
  $_SESSION['fav'] .= $code . ', ';
} else {
  $_SESSION['fav'] = $code. ', ';
}


if (empty($code)) {
  header("Location: /");
}

if (!$card_details) {
  header("Location: /code?find=true&code=$code");
} else {
?>
  <main>
    <div id="images">
      <img class="big_img" src="/card_img/<?=$card_details['code'];?>.jpg" alt="Main Card Image">

      <div class="card_small_img_border">
        <?php
        $abc = 'a';
        for ($i=0; $i < $card_details['imgs']; $i++) { ?>
          <img class="small_img" src="/card_img/<?=$card_details['code'];if($i) echo $abc;?>.jpg" alt="Main Card Image">
          <?php if($i) $abc++;
         } ?>
      </div>

    </div>

    <div id="details">
      <table>
        <?php
        unset($card_details['sub_categorie']);
        unset($card_details['categorie_code']);
        unset($card_details['imgs']);
        if ($card_details['item'] == '1') {
          $card_details = array_replace($card_details, ['item' => 'Available']);
        } elseif ($card_details['item'] == '0') {
          $card_details = array_replace($card_details, ['item' => 'Sold']);
        }
        foreach ($card_details as $key => $value): ?>
          <tr>
            <th class="details_th"><?= ucwords($key);?></th>
            <td class="details_td"><?php if($key === 'cost') echo '£' . number_format($value,2); else echo $value;
                      if($key === 'height' || $key === 'width') echo 'cm'; elseif ($key === 'weight') echo 'g'?></td>
          </tr>
        <?php endforeach; ?>
        <tr>
          <th class="details_th">More Information</th>
          <td class="details_td"><a href="/contact?c=<?=$code?>">contact details</a> </td>
        </tr>
      </table>
    </div>

  </main>
<?php } ?>

<?php include 'inc/footer.php'; ?>
