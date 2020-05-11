<?php
$find = filter_input(INPUT_GET, 'find', FILTER_SANITIZE_STRING);
$code = filter_input(INPUT_GET, 'code', FILTER_SANITIZE_STRING);
$css = '/css/code.css';
$js = '/js/code.js';
include 'controllers/functions.php';
$title = "Contact Rai";
include 'inc/header.php';
?>

<main>
  <?php if ($find): ?>
    <div class="sorry">
      <p>Sorry could not find that card (<span class="search_return"><?= $code ?></span>) <br> try searching with the filters <a href="/index.php">Categories</a></p>
    </div>
  <?php endif; ?>
  <form class="find_form" action="/details.php" method="get">
    <table>
      <tr>
        <td>
          <input class="input" type="text" name="code" placeholder="Enter code">
        </td>
        <td><input class="input" type="submit" value="Find"></td>
      </tr>
    </table>
  </form>


</main>

<?php  include 'inc/footer.php';?>
