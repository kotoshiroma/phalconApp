<h2>Sign up using this form</h2>

<!-- <?php echo $this->tag->form("signup/register"); ?> -->
<?= $this->tag->form(['signup/register', 'method' => 'post']) ?>
    <p>
        <label for="name">Name</label>
        <?php echo $this->tag->textField("name"); ?>
    </p>

    <p>
        <label for="email">E-Mail</label>
        <?php echo $this->tag->textField("email"); ?>
    </p>

    <p>
        <!-- <?php echo $this->tag->submitButton("Register"); ?> -->
        <?= $this->tag->submitButton(['Register']) ?>
    </p>

<!-- </form> -->
<?= $this->tag->endForm() ?>

<a href="#">
    <img src="https://s.yimg.jp/images/login/btn/btnXSYid.gif" 
            width="241" height="28" alt="Yahoo! JAPAN IDでログイン" border="0" />
</a>