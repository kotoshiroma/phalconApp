<div class="flex--centering flex--direct_column form_login">

    <h2>Sign Up</h2>

    {{ form("user/signUp", "method":"post") }}
        <p>
            {{ email_field("email", "class":"parts_loginForm", "placeholder":"email") }}
        </p>
        <p>
            {{ password_field("password", "class":"parts_loginForm", "size": 30, "placeholder":"password") }}
        </p>
        <p>
            {{ submit_button("Sign Up", "class":"btn btn-primary badge-pill parts_loginForm") }}
        </p>

    {{ end_form() }}

</div>