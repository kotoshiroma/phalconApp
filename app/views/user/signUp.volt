<div class="flex--centering" >
    <div class="flex--centering flex--direct_column form_login">

        <h2><?php echo $t->_("Sign Up"); ?></h2>

        <form action="/user/signUp", method="post">
            <p>
                 <input type="text" name="name" class="parts_loginForm pl-2" placeholder="<?php echo $t->_("username"); ?>" required>
            </p>
            <p>
                 <input type="email" name="email" class="parts_loginForm pl-2" placeholder="<?php echo $t->_("email"); ?>" required>                              
            </p>
            <p>
                 <input type="password" name="password" class="parts_loginForm pl-2" placeholder="<?php echo $t->_("password"); ?>" required>                                
            </p>
            <p>
                <button class="btn btn-primary badge-pill parts_loginForm">
                    <?php echo $t->_("Sign Up"); ?>
                </button>
            </p>
        </form>
    </div>
</div>