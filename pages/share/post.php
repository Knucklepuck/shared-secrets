<?php
  # prevent direct access
  if (!defined("SYS11_SECRETS")) {
      die("");
  }

  # define page title
  define("PAGE_TITLE", "Share a Secret.");

  $share_url = share_secret(SECRET_PARAM, $error);

  # set the correct response code on error
  if ((null === $share_url) || (false !== $error)) {
      http_response_code(403);
  }

  if (PLAIN_PARAM) {
      # set correct content type
      header("Content-Type: text/plain");

      if ((null !== $share_url) && (false === $error)) {
          print($share_url);
      }
  } else {
      if ((null !== $share_url) && (false === $error)) {
          $share_url = html($share_url);
      } else {
          $share_url = html($error);
      }

      # include header
      require_once(ROOT_DIR."/template/header.php");

      # prevents cache hits with wrong CSS
      $cache_value = md5_file(__FILE__);

      ?>

  <noscript>
    <div class="alert alert-warning">
      <strong>Warning!</strong> You don't have JavaScript enabled. You will not be able to share password-protected secrets.
    </div>
  </noscript>

<?php if ($error) : ?>
  <h2>Error:</h2>
  <p><pre id="secret"><?= $share_url ?></pre></p>
<?php else : ?>
  <h2>Share URL</h2>
  <p>This unique web address will give one-time access to the secret you entered. You can also <a href="/">create a new secret</a>.</p>
  <p><pre id="secret"><?= $share_url ?></pre></p>
  <button type="submit" class="btn btn-default" onclick="copyURL()">Copy to clipboard</button>
<?php endif; ?>

  <link href="/resources/css/share.css?<?= $cache_value ?>" integrity="sha256-EYu1Dc10IDi0yUOyV55YWmCKWfVlBj1rTMk/AsbViKE=" rel="stylesheet" type="text/css" />

  <script src="/resources/js/norepost.js?<?= $cache_value ?>" integrity="sha256-SdShL5XtGY7DRT4OatFFRS1b3QdADS22I8eEP1GA/As=" type="text/javascript"></script>
  <script src="/resources/js/share.js?<?= $cache_value ?>" integrity="sha256-PuW7cp6YZljGxqICj3wg/TVS1/uYxDr8+ATmF2QDmCk=" type="text/javascript"></script>
  <script src="/resources/js/copy.js?ver=<?= $cache_value ?>" integrity="sha256-oW0vQgPpJqiq2l2XJGgpb4Nffmc9VsjjfcTQdKFiGD8=" type="text/javascript"></script>

<?php
          # include footer
          require_once(ROOT_DIR."/template/footer.php");
  }
