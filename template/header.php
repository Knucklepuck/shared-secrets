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
    <link href="/style.css?<?php print($cache_value); ?>" rel="stylesheet" type="text/css" />
    <link rel="apple-touch-icon" sizes="180x180" href="favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicons/favicon-16x16.png">
    <link rel="manifest" href="favicons/site.webmanifest">
    <link rel="mask-icon" href="favicons/safari-pinned-tab.svg" color="#5bbad5">
    <link rel="shortcut icon" href="favicons/favicon.ico">
    <meta name="msapplication-TileColor" content="#603cba">
    <meta name="msapplication-TileImage" content="favicons/mstile-144x144.png">
    <meta name="msapplication-config" content="favicons/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">
  </head>

  <body>
    <div class="jumbotron text-center">
      <h1><a href="/"><?php print(htmlentities(SERVICE_TITLE)); ?></a></h1>
      <p>Paste a password, private link, or other secret message below.</p>
    </div>

    <div class="container">
      <!-- header -->
