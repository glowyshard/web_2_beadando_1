<?php
    require_once('config.inc.php');
?>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">
      <img src="media/logo.ico" alt="The Sweet Oven" height="60" width="60">
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="nav nav-tabs">
        <?php foreach($menu as $key => $menu_item) { ?>
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="<?php echo $menu_item['link']; ?>">
                    <?php echo $menu_item['text']; ?>
                </a>
            </li>
        <?php } ?>
      </ul>
    </div>

    <!-- Button on the far right -->
    <div class="ml-auto">
    <a href="/web_2_beadando_1-main/fiok.php" class="btn btn-primary">Login</a>
    </div>
  </div>
</nav>
