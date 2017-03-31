<!DOCTYPE html>
<html>
    <head>
        <title><?= app::getRouter()->getController() ?></title>
        <link rel="stylesheet" href="/css/style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        <script src="/js/script.js"></script>
    </head>
    <body>
        
        <header>
            <img class="logo" src="http://www.sourcecertain.com/img/Example.png"/>
        </header>

        <ul>
            <li><a href="#">Главная</a></li>
            <li><a href="#">Категории</a></li>
            <li><a href="#">Видео</a></li>
            <li><a href="#">Галерея</a></li>
      
            <li class="reg"><a>Регистрация</a></li>
            <li class="login"><a>Вход</a></li>
        </ul>
        
        <div class="popup">
            <div class="overlay"></div>
            <form method="post" action="<?=Config::get('domain')?>api/auth">
                <div class="login">
                    <img src="/images/close.png" class="popup_closer">
                    <table>
                        <thead>
                            <tr>
                                <td colspan="2"><p>Sign In</p></td>
                            </tr>
                        </thead>
                        <tr>
                            <td><img src="/images/user-login.png"></td>
                            <td><input type="text" class="auth_login" name="user" placeholder="Username"></td>
                        </tr>
                        <tr>
                            <td><img src="/images/user-pass.png"></td>
                            <td><input type="password" class="auth_pass"  name="pass" placeholder="Password"></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <label><input type="checkbox" name="cb_save_pass" checked>Remember me</label>
                                <span class="reset_pass"><a href="<?=Config::get('domain')?>resetpass">Forgot your password?</a></span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><input class="bt_auth" type="submit" value="Login"></td>
                        </tr>
                    </table>
                </div>
            </form>
        </div>

        <section>
            <?=$content?>
        </section>
        
        <footer>
            
        </footer>
        
    </body>
</html>