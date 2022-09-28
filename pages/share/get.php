<?php
  # prevent direct access
  if (!defined("SYS11_SECRETS")) {
      die("");
  }

  # define page title
  define("PAGE_TITLE", "Share a Secret.");

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

  <form role="form" action="/<?= html(SECRET_URI) ?><?= (PLAIN_PARAM) ? "?plain" : "" ?>" method="post">
    <h1>Share a Secret</h1>
    <p>Entire the secret you would like to share and click the button.</p>
    <div id="secret-div">
      <textarea autocomplete="off" class="form-control" id="secret" name="secret" rows="5" required="required"></textarea>
      <div id="counter"><?= MAX_PARAM_SIZE ?></div>
    </div>
    <button type="submit" class="btn btn-default" id="share-secret-btn" name="share-secret-btn">Share the Secret!</button>
  </form>

  <link href="/resources/css/share.css?<?= $cache_value ?>" integrity="sha256-EYu1Dc10IDi0yUOyV55YWmCKWfVlBj1rTMk/AsbViKE=" rel="stylesheet" type="text/css" />

  <script src="/resources/js/lib.js?<?= $cache_value ?>" integrity="sha256-TSNgGTWMqT8DICfF7UgTtxjnc/G935Ml4oxIQnHAxSM=" type="text/javascript"></script>
<?php
    if (defined("JUMBO_SECRETS") && JUMBO_SECRETS) {
        ?>
  <script src="/resources/js/jumbo_limit.js?<?= $cache_value ?>" integrity="sha256-7OnyT9osWKeiIPJ7xJ8IF1UYF3c/rpy2+ku0sQ0oue4=" type="text/javascript"></script>
<?php
    } else {
        ?>
  <script src="/resources/js/limit.js?<?= $cache_value ?>" integrity="sha256-HwcYaoqBBJhR7Y7eG2CepXkamos6C6SaViLGifuuo4E=" type="text/javascript"></script>
<?php
    }
  ?>
  <script src="/resources/js/share.js?<?= $cache_value ?>" integrity="sha256-PuW7cp6YZljGxqICj3wg/TVS1/uYxDr8+ATmF2QDmCk=" type="text/javascript"></script>
  <script src="/resources/js/copy.js?ver=<?= $cache_value ?>" integrity="sha256-oW0vQgPpJqiq2l2XJGgpb4Nffmc9VsjjfcTQdKFiGD8=" type="text/javascript"></script>

<?php

    # include footer
    require_once(ROOT_DIR."/template/footer.php");
