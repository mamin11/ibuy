<?php
// require_once 'core/init.php'; no need to require again as its required in header
require 'header.php';

if(Input::exists()){
    if(Token::check(Input::get('token'))){
        $validate =new Validate();
        //validate the user input
        $validation = $validate->check($_POST, array(
            'username' => array('required' => true),
            'user_password' => array('required' => true)
        ));

        if($validation->passed()){
            //log in user
            $user = new User();
            //chekc whether the user clicked remember me
            $remember = (Input::get('remember') === 'on') ? true : false;
            $login = $user->login(Input::get('username'), Input::get('user_password'), $remember);

            if($login){
                // echo 'success! Logged in';
                Redirect::to('home.php');
            }else{
                echo '<p>Login failed</p>';
            }
        }else{
            foreach($validation->errors() as $error){
                echo $error, '<br>';
            }
        }
    }
}
?>

<form action="" method="post">
    <div class="field">
        <label for="username">username </label>
        <input type="text" name="username" id="userrname" autocomplete="off">
    </div>

    <div class="field">
        <label for="user_password">password </label>
        <input type="password" name="user_password" id="user_password" autocomplete="off">
    </div>

    <div class="field">
        <label for="remember">
            <input type="checkbox" name="remember" id="remember"> Remember me
        </label>
    </div>

    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
    <input type="submit" value="sign in">
</form>

<?php