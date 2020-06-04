<?php
$css = '/css/contact.css';
$js = '/js/contact.js';
include 'controllers/functions.php';
$title = "Contact Rai";
include 'inc/header.php';
$mail_ok = filter_input(INPUT_GET, 'mail', FILTER_SANITIZE_STRING);
$code = filter_input(INPUT_GET, 'c', FILTER_SANITIZE_STRING);
require_once 'vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
?>
<script src="https://www.google.com/recaptcha/api.js?render=<?=getenv('site_key')?>"></script>

<?php if ($mail_ok == 'ok'){ ?>
  <p class="ok email_message">Mail sent. Thank you</p>
<?php } elseif($mail_ok == 'failed') { ?>
  <p class="failed email_message">Mail Failed. Try again</p>
<?php } ?>
<main>
  <form class="contact_form" action="/controllers/swift.php" method="post">
    <input hidden type="text" id="g-recaptcha-response" name="g-recaptcha-response" >
    <table>
      <tr>
        <th> <label for="name">Name:</label></th>
        <td><input id='name' type="text" name="name" placeholder="Enter first name."> </td>
      </tr>
      <tr>
        <th> <label for="code">Code:</label></th>
        <td><input id='code' type="text" name="code" placeholder="Enter code here." value="<?=$code ?>"> </td>
      </tr>
      <tr>
        <th> <label for="phone">Phone:</label></th>
        <td class="td_phone" ><input id='phone' type="numbers" name="phone" placeholder="Landline or Mobile."> </td>
      <tr>
        <th ><label for="email">Email Address:</label></th>
        <td class="td_email"><input id='email' type="email" name="email" placeholder="Enter E-Mail."> </td>
      </tr>
      <tr>
        <th ><label for="information">Information</label></th>
        <td><textarea id='information' type="text" name="information" placeholder="Let me know if you want a card making."></textarea></td>
      </tr>
    </table>
    <input disabled id=send type="submit" value="Send">
  </form>
</main>
<script>
grecaptcha.ready(function() {
    grecaptcha.execute("<?=getenv('site_key')?>", {action: 'homepage'}).then(function(token) {
       console.log(token);
       document.getElementById('g-recaptcha-response').value = token;
    });
});
</script>


<?php  include 'inc/footer.php';?>
