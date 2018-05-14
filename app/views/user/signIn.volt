<div class="flex--centering flex--direct_column form_login">

    <h2>Sign In</h2>

    {{ form("user/signIn", "method":"post") }}
        <p>
            {{ email_field("email", "class":"parts_loginForm", "placeholder":"email") }}
        </p>
        <p>
            {{ password_field("password", "class":"parts_loginForm", "size": 30, "placeholder":"password") }}
        </p>
        <p>
            {{ submit_button("Sign In", "class":"btn btn-primary badge-pill parts_loginForm") }}
        </p>

    {{ end_form() }}

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
