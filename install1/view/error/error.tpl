<?php include 'view/common/header.tpl'; ?>
<div class="wrapper">
  <div class="logo">
    <img src="public/image/logo.png" alt="">
    <h1>Error Found</h1>
  </div>
  <div class="container">
    <p class="error">
      <i class="fa fa-exclamation-circle"></i>
      <?php print_r($this->error); ?>
    </p>
    <div class="form-submit">
      <a class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored" href="index.php?route=install/1">let's Start</a>
    </div>
  </div>
</div>
<?php include 'view/common/footer.tpl'; ?>