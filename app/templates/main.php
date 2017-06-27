<!DOCTYPE html>
<html>
    <head>
        <title><?= app::getRouter()->getController() ?></title>
        <link rel="stylesheet" href="/css/style.css">
        <script src="/js/jquery-3.2.0.min.js"></script>
        <script src="/js/script.js"></script>
    </head>
    <body data-domain="<?=Config::get('domain')?>">
        
        <header>
            <img class="logo" src="http://www.sourcecertain.com/img/Example.png"/>
        </header>

        <ul class="main_menu">
            <li class="li_menu"><a href="/main">Главная</a></li>
      
            <?php if (Module_Auth::instance()->is_login() && Module_Auth::instance()->getUser()["gender"] == "men"): ?>
            <li class="logout"><a href="/api/logout"><img src="/images/logout-button.png"></a></li>
            <li class="profile"><a href="/profile"><img src="/images/def-avatar-men.png"></a></li>
            <?php elseif (Module_Auth::instance()->is_login() && Module_Auth::instance()->getUser()["gender"] == "women"): ?>
            <li class="logout"><a href="/api/logout"><img src="/images/logout-button.png"></a></li>
            <li class="profile"><a href="/profile"><img src="/images/def-avatar-women.png"></a></li>
            <?php else: ?>
            <li class="reg"><img src="/images/add-new-user.png"></li>
            <li class="login"><img src="/images/login-button.png"></li>
            <?php endif; ?>
        </ul>
        
        <div class="popup">
            <div class="overlay"></div>
            <form class="form_login">
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
                            <td><input type="text" name="user" placeholder="Имя пользователя" pattern="^[a-zA-Z0-9_-]{3,16}$" title="Буквы англ алфавита, цифры, дефисы и подчёркивания, от 3 до 16 символов." required></td>
                        </tr>
                        <tr>
                            <td><img src="/images/user-pass.png"></td>
                            <td><input type="password" name="pass" placeholder="Пароль" pattern="^[a-zA-Z0-9_-]{6,18}$" title="Буквы англ алфавита, цифры, дефисы и подчёркивания, от 6 до 18 символов." required></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <label><input type="checkbox" name="cb_save_pass" checked>Запомнить меня</label>
                                <span class="reset_pass">Забыли пароль?</span>
                            </td>
                        </tr>
                        <tr class="status">
                            <td colspan="2">
                                <label></label>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><input class="bt_auth" type="submit" value="Войти"></td>
                        </tr>
                    </table>
                </div>
            </form>
            <form class="form_resetpass">
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
                            <td><input type="text" class="resetpass_login" name="user" pattern="^[a-zA-Z0-9_-]{3,16}$" title="Буквы англ алфавита, цифры, дефисы и подчёркивания, от 3 до 16 символов." placeholder="Имя пользователя" required></td>
                        </tr>
                        <tr class="status">
                            <td colspan="2">
                                <label></label>
                            </td>
                        </tr>
                        <tr class="status">
                            <td colspan="2">
                                <label></label>
                            </td>
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
            <form class="form_registration">
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
                            <td><input type="text" name="user" pattern="^[a-zA-Z0-9_-]{3,16}$" title="Буквы англ алфавита, цифры, дефисы и подчёркивания, от 3 до 16 символов." placeholder="Имя пользователя" required></td>
                        </tr>
                        <tr>
                            <td><img src="/images/email.png"></td>
                            <td>
                                <input type="email" name="email" placeholder="Адрес електронной почты" pattern="^([a-zA-Z0-9_\.-]+)@([a-zA-Z0-9_\.-]+)\.([a-zA-Z\.]{2,6})$" title="Адрес должен быть вида example@test.com" required>
                            </td>
                        </tr>
                        <tr>
                            <td><img src="/images/user-pass.png"></td>
                            <td><input type="password" name="pass" placeholder="Пароль" pattern="^[a-zA-Z0-9_-]{6,18}$" title="Буквы англ алфавита, цифры, дефисы и подчёркивания, от 6 до 18 символов." required></td>
                        </tr>
                        <tr>
                            <td><img src="/images/user-pass.png"></td>
                            <td><input type="password" name="pass_confirmed" placeholder="Повторите пароль" pattern="^[a-zA-Z0-9_-]{6,18}$" title="Буквы англ алфавита, цифры, дефисы и подчёркивания, от 6 до 18 символов." required></td>
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
                        <tr class="status">
                            <td colspan="2">
                                <label></label>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input class="bt_reg" type="submit" value="Регистрация" required>
                            </td>
                        </tr>
                    </table>
                </div>
            </form>
            <form class="form_reg_success">
                <div class="reg_success">
                    <img src="/images/close.png" class="popup_closer">
                    <table>
                        <thead>
                            <tr>
                                <td colspan="2"><p>Вы зарегистрирываны</p></td>
                            </tr>
                        </thead>
                        <tr>
                            <td colspan="2"><label>Перейдите по ссылке из письма отправленого на вашу електронную почту что бы подтвердить регистрацию</label></td>
                        </tr>
                        <tr>
                            <td colspan="2"><input class="bt_ok" type="button" value="Ок" onclick="hideAll_form()"></td>
                        </tr>
                    </table>
                </div>
            </form>
        </div>

        <section>
            <?=$content?>
        </section>
        
        <footer>
            <br><p>2017 All right reserved</p>
        </footer>
        
    </body>
</html>