<div class="flex--centering">
    <div class="flex--centering flex--direct_column form_login">

        <h2><?php echo $t->_("Sign In"); ?></h2>
        <?php $this->flashSession->output(); ?>

        <form action="/user/signIn" method="post">
            <p>
                <input type="email" name="email" class="parts_loginForm pl-2" placeholder="<?php echo $t->_("email"); ?>" required> 
            </p>
            <p>
                <input type="password" name="password" class="parts_loginForm pl-2" size="30"
                         placeholder="<?php echo $t->_("password"); ?>" required>
            </p>
            <p>
                <button class="btn btn-primary badge-pill parts_loginForm">
                    <?php echo $t->_("Sign In"); ?>
                </button>
            </p>

        </form>

        <p style="color:gray;">
            もしくは
        </p>
        <a href="/user/redirect_to_yahooAuthEndPoint">
            <img src="https://s.yimg.jp/images/login/btn/btn_login_a_196.png" 
                width="196" height="38" alt="Yahoo! JAPAN IDでログイン" border="0" />
        </a>
    </div>
</div>