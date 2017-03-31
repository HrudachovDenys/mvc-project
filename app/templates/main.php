<!DOCTYPE html>
<html>
    <head>
        <title><?= app::getRouter()->getController() ?></title>
        <link rel="stylesheet" href="<?=Config::get('dir_root')?>web/css/style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
        <script src="<?=Config::get('dir_root')?>web/js/script.js"></script>
    </head>
    <body>
        
        <header>
            <img class="logo" src="http://www.sourcecertain.com/img/Example.png"/>
        </header>

        <div class="popup">
            <div class="overlay"></div>
            <div class="login">
                <h1>Login</h1>
                <form>
                    <table>
                        <tr>
                            <td><label>Login:</label></td>
                            <td><input type="text" name="login" placeholder="username"></td>
                        </tr>
                        <tr>
                            <td><label>Pass:</label></td>
                            <td><input type="password" name="pass" placeholder="password"></td>
                        </tr>
                        <tr>
                            <td colspan="2"><input type="submit" value="Login"></td>
                        </tr>
                    </table>
                </form>
            </div>
            <div class="reg">
                <h1>Регистрация</h1>
            </div>
        </div>

        <ul>
            <li><a href="#">Главная</a></li>
            <li><a href="#">Категории</a></li>
            <li><a href="#">Видео</a></li>
            <li><a href="#">Галерея</a></li>
      
            <li class="reg"><a href="#">Регистрация</a></li>
            <li class="login"><a href="#">Вход</a></li>
        </ul>


        
        <section>
            <?=$content?>
        </section>
        
        <footer>
            
        </footer>
        
    </body>
</html>