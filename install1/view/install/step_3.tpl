<?php include 'view/common/header.tpl'; ?>
    <div class="wrapper">
        <div class="logo">
            <img src="public/image/logo.png" alt="">
            <h1>Installation Complete</h1>
        </div>
        <div class="container">
           <?php if(is_dir('../install')) { ?>
            <p class="error">
                <i class="fa fa-exclamation-circle"></i> Do not forget to delete installation directory!
            </p>
            <?php } ?>
            <h5>
                Congratulations, Your installation is done. You appointment and patient management system is ready!
            </h5>
            <div class="install-success">
                <div class="install-success-block">
                    <i class="fa fa-globe"></i>
                    <a href="../" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored">Admin Portal</a>
                </div>
                 <div class="install-success-block">
                    <i class="fa fa-gear"></i>
                    <a href="../clients" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored">Client Portal</a>
                </div>
            </div>
        </div>
    </div>
    <?php include 'view/common/footer.tpl'; ?>