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
                                <td colspan="2"><p>Авторизация</p></td>
                            </tr>
                        </thead>
                        <tr>
                            <td><img src="/images/user-login.png"></td>
                            <td><input type="text" name="user" placeholder="Имя пользователя" required></td>
                        </tr>
                        <tr>
                            <td><img src="/images/user-pass.png"></td>
                            <td><input type="password" name="pass" placeholder="Пароль" required></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <label><input type="checkbox" name="cb_save_pass" checked>Запомнить меня</label>
                                <span class="reset_pass">Забыли пароль?</span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><input class="bt_auth" type="submit" value="Войти"></td>
                        </tr>
                    </table>
                </div>
            </form>
            <form method="post" action="<?=Config::get('domain')?>api/resetpass">
                <div class="resetpass">
                    <img src="/images/close.png" class="popup_closer">
                    <table>
                        <thead>
                            <tr>
                                <td colspan="2"><p>Востановление пароля</p></td>
                            </tr>
                        </thead>
                        <tr>
                            <td><img src="/images/user-login.png"></td>
                            <td><input type="text" class="resetpass_login" name="user" placeholder="Имя пользователя" required></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input class="bt_reset" type="submit" value="Сбросить пароль">
                                <input class="bt_cancel" type="button" value="Отмена">
                            </td>
                        </tr>
                    </table>
                </div>
            </form>
            <form method="post" action="<?=Config::get('domain')?>api/auth">
                <div class="registration">
                    <img src="/images/close.png" class="popup_closer">
                    <table>
                        <thead>
                            <tr>
                                <td colspan="2"><p>Регистрация</p></td>
                            </tr>
                        </thead>
                        <tr>
                            <td><img src="/images/user-login.png"></td>
                            <td><input type="text" name="user" placeholder="Имя пользователя" required></td>
                        </tr>
                        <tr>
                            <td><img src="/images/email.png"></td>
                            <td><input type="email" name="email" placeholder="Адрес електронной почты" required></td>
                        </tr>
                        <tr>
                            <td><img src="/images/user-pass.png"></td>
                            <td><input type="password" name="pass" placeholder="Пароль" required></td>
                        </tr>
                        <tr>
                            <td><img src="/images/user-pass.png"></td>
                            <td><input type="password" name="pass" placeholder="Повторите пароль" required></td>
                        </tr>
                        <tr>
                            <td><img src="/images/gender.png"></td>
                            <td>
                                <input type="radio" name="gender" value="men" required><label>Мужской</label>
                                <input type="radio" name="gender" value="women" required><label>Женский</label>
                            </td>
                        </tr>
                        <tr>
                            <td><img src="/images/date-birthday.png"></td>
                            <td>
                                <input type="date" class="date_birhday" name="date_bithday" required>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><input class="bt_reg" type="submit" value="Регистрация" required></td>
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