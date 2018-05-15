<div class="flex--centering" >
    <div class="flex--centering flex--direct_column form_login">

        <h2>Sign Up</h2>

        <?= $this->tag->form(['user/signUp', 'method' => 'post']) ?>
            <p>
                <?= $this->tag->textField(['name', 'class' => 'parts_loginForm', 'placeholder' => 'username']) ?>
            </p>
            <p>
                <?= $this->tag->emailField(['email', 'class' => 'parts_loginForm', 'placeholder' => 'email']) ?>
            </p>
            <p>
                <?= $this->tag->passwordField(['password', 'class' => 'parts_loginForm', 'size' => 30, 'placeholder' => 'password']) ?>
            </p>
            <p>
                <?= $this->tag->submitButton(['Sign Up', 'class' => 'btn btn-primary badge-pill parts_loginForm']) ?>
            </p>

        <?= $this->tag->endForm() ?>
    </div>
</div>