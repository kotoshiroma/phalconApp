<div class="flex--centering" >
    <div class="flex--centering flex--direct_column form_login">

        <h2><?php echo $t->_("Sign Up"); ?></h2>
        <?php $this->flashSession->output(); ?>

        <?= $this->tag->form(['user/signUp', 'method' => 'post']) ?>
            <p>
                 <?php 
                    echo $userform->render("name", [
                         "class" => "parts_loginForm pl-2", 
                         "placeholder" => $t->_("username")
                    ]); 
                 ?>
            </p>
            <p>
                 <?php echo $userform->render("email", ["class" => "parts_loginForm pl-2", "placeholder" => $t->_("email")]); ?>               
            </p>
            <p>
                 <?php echo $userform->render("password", ["class" => "parts_loginForm pl-2", "placeholder" => $t->_("password")]); ?>                
            </p>
            <p>
                <button class="btn btn-primary badge-pill parts_loginForm">
                    <?php echo $t->_("Sign Up"); ?>
                </button>
            </p>

        <?= $this->tag->endForm() ?>
    </div>
</div>