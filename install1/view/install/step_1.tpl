<?php include 'view/common/header.tpl'; ?>
    <div class="wrapper">
        <div class="logo">
            <img src="public/image/logo.png" alt="">
            <h1>Pre Installation</h1>
        </div>
        <div class="container">
            <p>
                Welcome to Office Manger. Before we proceed, we need some information on the database. You will need to know the following items before proceeding.
            </p>
            <ul>
                <li>1. Database name</li>
                <li>2. Database username</li>
                <li>3. Database password</li>
                <li>4. Database host</li>
            </ul>
            <p>
                We’re going to use this information to create a configuration file.	If for any reason this automatic installer doesn’t work, don’t worry. You can go for manual process which is described in documentation.
                Need more help? <a href="http://support.pepdev.com/" target="_blank">Create ticket here</a>
            </p>
            <div class="form-submit">
                <a class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored" href="index.php?route=install/2">let's Start</a>
            </div>
        </div>
    </div>
    <?php include 'view/common/footer.tpl'; ?>