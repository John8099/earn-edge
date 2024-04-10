  <!-- header -->
  <div class="logo_products">
    <div class="container">
      <div class="row">
        <div class="col-md-4">
          <div class="w3l_search" style="width: 100%">
            <div class="input-group">
              <input type="text" class="form-control" name="Search" placeholder="Search for a Product..." id="search" required="">
              <span class="input-group-btn">
                <button type="button" class="btn btn-primary search" aria-label="Left Align" id="btnSearch">
                  <i class="fa fa-search" aria-hidden="true"> </i>
                </button>
              </span>

            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="w3ls_logo_products_left" style="width: 100%">
            <h1><a href="<?= SERVER_NAME . "/" ?>">EarnEdge</a></h1>
          </div>

        </div>
        <div class="col-md-4">
          <ul class="nav nav-pills" style="float:right;">
            <?php if ($LOGIN_USER) : ?>
              <li role="presentation">
                <a href="<?= SERVER_NAME . "/backend/nodes?action=logout" ?>">Logout</a>
              </li>
            <?php else : ?>
              <li role="presentation">
                <a href="<?= SERVER_NAME . "/login" ?>">Login</a>
              </li>
              <li role="presentation">
                <a href="<?= SERVER_NAME . "/registration" ?>">Sign up</a>
              </li>
            <?php endif; ?>
            <?php if ($LOGIN_USER) : ?>
              <li role="presentation">
                <a href="<?= SERVER_NAME . "/cart" ?>" id="btnCart" style="font-size: 22px;">
                  <i class="fa fa-cart-arrow-down"></i>
                </a>
              </li>
            <?php endif ?>
          </ul>
        </div>
      </div>

    </div>
  </div>
  <!-- //header -->
  <!-- navigation -->
  <div class="navigation-agileits">
    <div class="container">

      <nav class="navbar navbar-default">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header nav_2">
          <button type="button" class="navbar-toggle collapsed navbar-toggle1" data-toggle="collapse" data-target="#bs-megadropdown-tabs">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
        <div class="collapse navbar-collapse" id="bs-megadropdown-tabs">
          <ul class="nav navbar-nav">
            <li><a href="<?= SERVER_NAME . "/" ?>" class="act">Home</a></li>
            <li><a href="<?= SERVER_NAME . "/shop" ?>" class="act">Shop</a></li>
            <?php if ($LOGIN_USER) : ?>
              <li><a href="<?= SERVER_NAME . "/profile" ?>" class="act">My Profile</a></li>
              <li><a href="<?= SERVER_NAME . "/orders" ?>" class="act">Orders</a></li>
            <?php endif; ?>
          </ul>
        </div>
      </nav>
    </div>
  </div>

  <!-- //navigation -->