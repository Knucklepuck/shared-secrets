<?php
  # prevent direct access
  if (!defined("SYS11_SECRETS")) {
      die("");
  }

  # define page title
  define("PAGE_TITLE", "Read a Secret.");

  # include header
  require_once(ROOT_DIR."/template/header.php");

  # prevents cache hits with wrong CSS
  $cache_value = md5_file(__FILE__);

  $encrypted_secret = false;
  $error = false;
  $secret_uri = SECRET_URI;

  if ($link = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS, MYSQL_DB, MYSQL_PORT)) {
    try {
        if ($statement = mysqli_prepare($link, MYSQL_READ_SHARE)) {
            if (mysqli_stmt_bind_param($statement, "s", $secret_uri)) {
                if (mysqli_stmt_execute($statement)) {
                  mysqli_stmt_bind_result($statement, $encrypted_secret);
                  mysqli_stmt_fetch($statement);
                } else {
                    if (DEBUG_MODE) {
                        $error = "Select statement could not be executed";
                    }
                }
            } else {
                if (DEBUG_MODE) {
                    $error = "Select statement parameters could not be bound.";
                }
            }
        } else {
            if (DEBUG_MODE) {
                $error = "Select statement could not be prepared.";
            }
        }
    } finally {
        mysqli_close($link);
    }
  } else {
      if (DEBUG_MODE) {
          $error = "Database connection could not be established.";
      }
  }
  if (!$encrypted_secret) {
    $error = "URI not found.";
  }
  ?>

  <noscript>
    <div class="alert alert-warning">
      <strong>Warning!</strong> You don't have JavaScript enabled. You will not be able to read password-protected secrets.
    </div>
  </noscript>
  <? if ($error) : ?>
    <h1>Secret Used</h1>
    <p>This secret has already been used, but you can <a href="/">create a new one</a>.</p>
  <?php else : ?>
    <h1>Read Secret?</h1>
    <p>This secret is ready, but you will only be able to read a secret once. If you're not ready to use this one-time link, do not click the button below.</p>

    <form role="form" action="/<?= html($encrypted_secret) ?><?= (PLAIN_PARAM) ? "?plain" : "" ?>" method="post">
      <button type="submit" class="btn btn-default" id="read-secret-btn" name="read-secret-btn">Read the Secret!</button>
    </form>
  <?php endif; ?>

  <link href="/resources/css/read.css?<?= $cache_value ?>" integrity="sha256-wgpxEGDMqG2EJxicZqc40OJMPwN8rBAZTYLdGyagQGw=" rel="stylesheet" type="text/css" />
  <script src="/resources/js/copy.js?ver=<?= $cache_value ?>" integrity="sha256-oW0vQgPpJqiq2l2XJGgpb4Nffmc9VsjjfcTQdKFiGD8=" type="text/javascript"></script>

<?php

    # include footer
    require_once(ROOT_DIR."/template/footer.php");
