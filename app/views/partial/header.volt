<div class="header mt-2">
    <div class="header-start container">
        <ul class="nav float-l">
            <li class="nav-item">
                <a class="nav-item" href="/index/index">TOP</a>
            </li>
        </ul>
    </div>
    <div class="header-end container">
        <ul class="nav float-r">
                
            <?php if ($this->session->get("user")->name !== null) { ?>
                    <li class="nav-item flex--centering mr-1">
                        <a class="nav-item">
                            <?php echo $this->session->get("user")->name; ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/user/logOut" class="nav-item btn btn-primary"><?php echo $t->_("LogOut"); ?></a>
                    </li>

            <?php } else { ?>
                    <li class="nav-item">
                        <a href="/user/signUp" class="nav-item btn btn-primary mr-1"><?php echo $t->_("Sign Up"); ?></a>
                    </li>
                    <li class="nav-item">
                        <a href="/user/signIn" class="nav-item btn btn-primary"><?php echo $t->_("Sign In"); ?></a>                            
                    </li>
            <?php } ?>
        </ul>
    </div>
</div>