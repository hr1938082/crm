<?php include 'view/common/header.tpl'; ?>
    <div class="wrapper">
        <div class="logo">
            <img src="public/image/logo.png" alt="">
            <h1>Configuration Setup</h1>
        </div>
        <div class="container">
            <?php if(isset($_SESSION['ERROR_INPUT'])) { ?>
                <p class="error">
                    <?php foreach ($_SESSION['ERROR_INPUT'] as $value) { ?>
                       <i class="fa fa-exclamation-circle"></i> <?php echo $value; ?>
                    <?php } ?>
                </p>
            <?php unset($_SESSION['ERROR_INPUT']); } if(isset($_SESSION['ERROR'])) { ?>
            <p class="error">
                <?php echo $_SESSION['ERROR']; ?>
            </p>
            <?php unset($_SESSION['ERROR']); } ?>
            <form action="index.php?route=install/action" class="form-container" method="post">
                <h3>1. Please enter your database credentials.</h3>
                <div class="form-sub-input">
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label form-input">
                        <input class="mdl-textfield__input" type="text" name="db_name" id="db-name">
                        <label class="mdl-textfield__label" for="db-name">Database Name<em> *</em></label>
                        <span class="mdl-textfield__error">Please Enter Valid Database Name!</span>
                    </div>
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label form-input">
                        <input class="mdl-textfield__input" type="text" name="db_username" id="db-username">
                        <label class="mdl-textfield__label" for="db-username">Database Username<em> *</em></label>
                        <span class="mdl-textfield__error">Please Enter Valid Database Username!</span>
                    </div>
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label form-input">
                        <input class="mdl-textfield__input" type="text" name="db_password" id="db-password">
                        <label class="mdl-textfield__label" for="db-password">Database Password<em> *</em></label>
                        <span class="mdl-textfield__error">Please Enter Valid Database Password!</span>
                    </div>
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label form-input">
                        <input class="mdl-textfield__input" type="text" name="db_hostname" value="localhost" id="db-hostname">
                        <label class="mdl-textfield__label" for="db-hostname">Database Hostname<em> *</em></label>
                        <span class="mdl-textfield__error">Please Enter Valid Hostname!</span>
                    </div>
                     <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label form-input">
                        <input class="mdl-textfield__input" type="text" name="db_prefix" value="cm_" id="db-prefix">
                        <label class="mdl-textfield__label" for="db-prefix">Table Prefix<em> *</em></label>
                        <span class="mdl-textfield__error">Please Enter Valid Table Prefix!</span>
                    </div>
                </div>
                <h3>2. Please enter a username and password for the admin.</h3>
                <div class="form-sub-input">
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label form-input">
                        <input class="mdl-textfield__input" type="text" name="name" id="name">
                        <label class="mdl-textfield__label" for="name">Office Name or Site Name<em> *</em></label>
                        <span class="mdl-textfield__error">Please Enter Office Name!</span>
                    </div>
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label form-input">
                        <input class="mdl-textfield__input" type="text" name="email" id="email">
                        <label class="mdl-textfield__label" for="email">Email Address<em> *</em></label>
                        <span class="mdl-textfield__error">Please Enter Valid Email Address!</span>
                    </div>
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label form-input">
                        <input class="mdl-textfield__input" type="text" name="username" id="username">
                        <label class="mdl-textfield__label" for="username">Username<em> *</em></label>
                        <span class="mdl-textfield__error">Please Enter Valid Username!</span>
                    </div>
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label form-input">
                        <input class="mdl-textfield__input" type="text" name="password" id="password">
                        <label class="mdl-textfield__label" for="password">Password<em> *</em></label>
                        <span style="font-size: 12px;">Min 8 Characters required!</span>
                    </div>
                </div>
                <div class="form-submit">
                    <a class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect back" href="index.php?route=install/1">Back</a>
                    <button id="install-submit" name="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored">
                        Run Installation
                    </button>
                </div>
            </form>
        </div>
    </div>
    <?php include 'view/common/footer.tpl'; ?>