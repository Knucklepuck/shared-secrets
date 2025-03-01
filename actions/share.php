<?php

  # prevent direct access
  if (!defined("SYS11_SECRETS")) {
      die("");
  }

  function share_secret($secret, &$error = null)
  {
      $result = null;
      $error  = false;

      # only proceed when the read-only mode is not enabled
      if (!READ_ONLY) {
          # only proceed when the secret is not empty
          if (!empty($secret)) {
              # only proceed when the secret is not too long
              if (MAX_PARAM_SIZE >= strlen($secret)) {
                  # for shared-secrets we only support encryption with one key
                  $keys   = array_keys(RSA_PRIVATE_KEYS);
                  $pubkey = null;
                  if (is_pubkey(RSA_PRIVATE_KEYS[$keys[count($keys)-1]])) {
                      # open the public key
                      $pubkey = openssl_pkey_get_public(RSA_PRIVATE_KEYS[$keys[count($keys)-1]]);
                  } elseif (is_privkey(RSA_PRIVATE_KEYS[$keys[count($keys)-1]])) {
                      # extract the public key from the private key
                      $pubkey = open_pubkey(RSA_PRIVATE_KEYS[$keys[count($keys)-1]]);
                  }
                  if (null !== $pubkey) {
                      try {
                          $recipients = [$pubkey];
                          try {
                              $encrypted_secret = encrypt_v01($secret, $recipients, $encrypt_error);
                          } finally {
                              zeroize_array($recipients);
                          }

                          if (null !== $encrypted_secret) {
                              // Save secret to db
                              $encrypted_secret = apache_bugfix_encode(url_base64_encode(base64_encode($encrypted_secret)));
                              $uri              = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 12);

                              if ($link = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS, MYSQL_DB, MYSQL_PORT)) {
                                  try {
                                      if ($statement = mysqli_prepare($link, MYSQL_WRITE_SHARE)) {
                                          if (mysqli_stmt_bind_param($statement, "ss", $encrypted_secret, $uri)) {
                                              if (mysqli_stmt_execute($statement)) {
                                                  if (1 !== mysqli_affected_rows($link)) {
                                                      if (DEBUG_MODE) {
                                                          $error = $uri;
                                                          $error .= '<br>';
                                                          $error .= $encrypted_secret;
                                                          $error .= '<br>';
                                                          $error .= print_r($statement, true);
                                                      } else {
                                                          $error = "Please try again.";
                                                      }
                                                  }
                                              } else {
                                                  if (DEBUG_MODE) {
                                                      $error = "Insert statement could not be executed";
                                                  }
                                              }
                                          } else {
                                              if (DEBUG_MODE) {
                                                  $error = "Insert statement parameters could not be bound.";
                                              }
                                          }
                                      } else {
                                          if (DEBUG_MODE) {
                                              $error = "Insert statement could not be prepared.";
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

                              # return the secret sharing URL
                              $result = get_secret_url($uri);
                          } else {
                              if (DEBUG_MODE) {
                                  $error = "Encryption failed: $encrypt_error";
                              }
                          }
                      } finally {
                          openssl_pkey_free($pubkey);
                      }
                  } else {
                      if (DEBUG_MODE) {
                          $error = "Public key could not be read.";
                      }
                  }
              } else {
                  $error = "The secret must at most be ".MAX_PARAM_SIZE." characters long.";
              }
          } else {
              $error = "The secret must not be empty.";
          }
      } else {
          $error = "The creation of secret sharing links is disabled.";
      }

      # set default error if non is given
      if ((null === $result) && (false === $error)) {
          $error = "An unknown error occured.";
      }

      return $result;
  }
