<?php
  # prevent direct access
  if (!defined("SYS11_SECRETS")) {
      die("");
  }

  # prevents cache hits with wrong CSS
  $cache_value = md5_file(__FILE__);

  ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title><?php print(htmlentities(SERVICE_TITLE)); ?></title>

    <link href="/vendors/bootstrap/css/bootstrap.min.css?<?php print($cache_value); ?>" integrity="sha256-bZLfwXAP04zRMK2BjiO8iu9pf4FbLqX6zitd+tIvLhE=" rel="stylesheet" type="text/css" />

    <!--[if lt IE 9]>
      <script src="/vendors/html5shiv/html5shiv.min.js?<?php print($cache_value); ?>" integrity="sha256-3Jy/GbSLrg0o9y5Z5n1uw0qxZECH7C6OQpVBgNFYa0g=" type="text/javascript"></script>
      <script src="/vendors/respond/respond.min.js?<?php print($cache_value); ?>" integrity="sha256-ggacFe3WlD36pZ9aw/asyG/USij+kl5BDM3K3sGUqLo=" type="text/javascript"></script>
    <![endif]-->
  </head>

  <body>
    <div class="jumbotron text-center">
      <h1><a href="/"><?php print(htmlentities(SERVICE_TITLE)); ?></a></h1>
      <p>Paste a password, private link, or other secret message below.</p>
    </div>

    <div class="container">
      <!-- header -->
