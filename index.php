<?php
  $current_page = isset($_GET['page']) ? $_GET['page'] : 'about';
?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Mark Anton Cahutay</title>
    <link rel="icon" href="assets/images/favicon/favicon.ico" type="image/x-icon" />
    <link rel="icon" type="image/png" sizes="32x32" href="assets/images/favicon/favicon-32x32.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon/favicon-16x16.png" />
    <link rel="stylesheet" href="styles.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@emailjs/browser@4/dist/email.min.js"></script>
  </head>

  <body>
    <div class="overlay"></div>

    <?php require_once 'component/header.php'; ?>

    <main>
      <?php require_once "pages/{$current_page}.php"; ?>
    </main>

    <footer class="footer">
      <p>&copy; 2025 Mark Anton Cahutay. All rights reserved.</p>
    </footer>

    <script src="assets/js/script.js"></script>
    <script src="assets/js/scroll.js"></script>
  </body>

</html>