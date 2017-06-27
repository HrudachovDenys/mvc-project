<div class="div_profile">
    <ul class="profile_menu">
        
        <?php if(Module_Auth::instance()->getRole() == 'unconfirmed') : ?>
        <li><a href="/profile">Профиль</a></li>
        <?php elseif(Module_Auth::instance()->getRole() == 'user') : ?>
        <li><a href="/profile">Профиль</a></li>
        <li><a href="/profile/addpost">Добавить пост</a></li>
        <?php elseif(Module_Auth::instance()->getRole() == 'admin') : ?>
        <li><a href="/profile">Профиль</a></li>
        <li><a href="/profile/addpost">Добавить пост</a></li>
        <li><a href="/adm/users">Пользователи</a></li>
        <li><a href="/adm/posts">Посты</a></li>
        <?php endif ; ?>
    </ul>
    <div class="profile_info">
        <?php if(Module_Auth::instance()->getRole() == 'unconfirmed') : ?>
            <h1 id="h1_message">Пользыватель не подтвержден. Перейдите по ссылке из письма отправленого на ваш email.</h1>
        <?php elseif(Module_Auth::instance()->getRole() == 'blocked') : ?>
            <h1 id="h1_message">Вы заблокированы!!!</h1>
        <?php else : ?>
            <?php if (Module_Auth::instance()->getUser()["firstname"] == null || Module_Auth::instance()->getUser()["lastname"] == null): ?>
            <h1 id="h1_flname">Имя и фомилия не заполнены</h1>
            <img class="edit_img" onclick="edit_flname()" src="/images/edit.png">
            <?php else: ?>
                <?php if (Module_Auth::instance()->is_login() && Module_Auth::instance()->getUser()["gender"] == "men"): ?>
                <img class="gender_flname" src="/images/def-avatar-men.png">
                <?php else: ?>
                <img class="gender_flname" src="/images/def-avatar-women.png">
                <?php endif;?>
            <h1 id="h1_flname"><?=Module_Auth::instance()->getUser()["firstname"] . ' ' . Module_Auth::instance()->getUser()["lastname"]?></h1>
            <img class="edit_img" onclick="edit_flname()" src="/images/edit.png">
            <?php endif; ?>
            <br><br><br><br>
            <?php if (Module_Auth::instance()->getUser()["country_id"] == null): ?>
            <form class="form_country" method="post" action="api/setcountry">
                <h3 id="h3_country">Страна: </h3>
                <select class="list_country" name="setcountry">
                    <?php foreach(Module_Profile::instance()->getCountry() as $country) :?>
                    <?php echo "<option value='" . $country["country"] . "'>" . $country["country"] . "</option>"?>
                    <?php endforeach; ?>
                </select>
                <input type="submit" value="" >
            </form>
            <?php else: ?>
            <h3 id="h3_country">Страна: <?= Module_Profile::instance()->getCountry(Module_Auth::instance()->getUser()["country_id"])?></h3>
            <br><img class="edit_img_country" onclick="edit_country()" src="/images/edit.png">
            <?php endif; ?>
            <br><br><br><h3 class="h3_email">Email: <?=Module_Auth::instance()->getUser()["email"]?></h3>
            <br><br><br><br><h3 id="h3_birthday">День рождения: <?= (new DateTime(Module_Auth::instance()->getUser()["date_birhday"]))->format('Y-m-d')?></h3>
            <br><br><br><br><h3 id="h3_about">Обо мне:</h3>
            <img class="edit_img_about" onclick="edit_about()" src="/images/edit.png">
            <br><br><br>
                <?php if (Module_Auth::instance()->getUser()["about_me"] == null): ?>
                <p class="p_about">Не заполнено</p>
                <?php else: ?>
                <p class="p_about"><?=Module_Auth::instance()->getUser()["about_me"]?></p>
                <?php endif; ?>
        <?php endif; ?>
    </div>
</div>
