<!DOCTYPE html>
<html>
    <head>
        <title><?= app::getRouter()->getController() ?></title>
        <link rel="stylesheet" href="css/style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
        <script src="js/script.js"></script>
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
      
            <li class="registation"><a href="#">Регистрация</a></li>
            <li class="login"><a href="#">Вход</a></li>
        </ul>
        
        <section>
            <?=$content?>
        </section>
        
        <footer>
            
        </footer>
        
    </body>
</html>