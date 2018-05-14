<div class="flex--centering flex--direct_column form_login">

    <h2>Sign In</h2>

    <?= $this->tag->form(['user/signIn', 'method' => 'post']) ?>
        <p>
            <?= $this->tag->emailField(['email', 'class' => 'parts_loginForm', 'placeholder' => 'email']) ?>
        </p>
        <p>
            <?= $this->tag->passwordField(['password', 'class' => 'parts_loginForm', 'size' => 30, 'placeholder' => 'password']) ?>
        </p>
        <p>
            <?= $this->tag->submitButton(['Sign In', 'class' => 'btn btn-primary badge-pill parts_loginForm']) ?>
        </p>

    <?= $this->tag->endForm() ?>

    <p style="color:gray;">
        もしくは
    </p>
    <!-- <a href="/user/signIn_by_yahooId">
        <img src="https://s.yimg.jp/images/login/btn/btnXSYid.gif" 
               width="241" height="28" alt="Yahoo! JAPAN IDでログイン" border="0" />
    </a> -->
    <a href="/user/redirect_to_yahooAuthEndPoint">
        <img src="https://s.yimg.jp/images/login/btn/btn_login_a_196.png" 
             width="196" height="38" alt="Yahoo! JAPAN IDでログイン" border="0" />
    </a>
</div>
