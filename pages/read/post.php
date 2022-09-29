<?php
  # prevent direct access
  if (!defined("SYS11_SECRETS")) {
      die("");
  }

  # define page title
  define("PAGE_TITLE", "Read a Secret.");

  $secret = read_secret(SECRET_URI, $error);

  # set the correct response code on error
  if ((null === $secret) || (false !== $error)) {
      http_response_code(403);
  }

  if (PLAIN_PARAM) {
      # set correct content type
      header("Content-Type: text/plain");

      if ((null !== $secret) && (false === $error)) {
          print($secret);
      }
  } else {
      if ((null !== $secret) && (false === $error)) {
          $secret = html($secret);
      } else {
          $secret = html($error);
      }

      # include header
      require_once(ROOT_DIR."/template/header.php");

      # prevents cache hits with wrong CSS
      $cache_value = md5_file(__FILE__);

      ?>

  <noscript>
    <div class="alert alert-warning">
      <strong>Warning!</strong> You don't have JavaScript enabled. You will not be able to read password-protected secrets.
    </div>
  </noscript>

<?php if ($error) : ?>
    <h2>Error:</h2>
    <p><pre id="secret"><?= $secret ?></pre></p>
<?php else : ?>
    <h2>Secret</h2>
    <p>Warning: Be sure use have used this before closing the page, it can not be restored. You can also <a href="/">create a new secret</a>.</p>
    <p><pre id="secret"><?= $secret ?></pre></p>
    <button type="submit" class="btn btn-default" onclick="copyURL()">Copy to clipboard</button>
<?php endif; ?>

  <link href="/resources/css/read.css?<?= $cache_value ?>" integrity="sha256-wgpxEGDMqG2EJxicZqc40OJMPwN8rBAZTYLdGyagQGw=" rel="stylesheet" type="text/css" />

  <script src="/resources/js/lib.js?<?= $cache_value ?>" integrity="sha256-TSNgGTWMqT8DICfF7UgTtxjnc/G935Ml4oxIQnHAxSM=" type="text/javascript"></script>
  <script src="/resources/js/read.js?<?= $cache_value ?>" integrity="sha256-0dlCa+2uL8Tgjq7VlZtajGikqq5BptgpEkQTc0xl1vU=" type="text/javascript"></script>
  <script src="/resources/js/norepost.js?<?= $cache_value ?>" integrity="sha256-SdShL5XtGY7DRT4OatFFRS1b3QdADS22I8eEP1GA/As=" type="text/javascript"></script>
  <script src="/resources/js/copy.js?ver=<?= $cache_value ?>" integrity="sha256-oW0vQgPpJqiq2l2XJGgpb4Nffmc9VsjjfcTQdKFiGD8=" type="text/javascript"></script>

<?php

          # include footer
          require_once(ROOT_DIR."/template/footer.php");
  }
