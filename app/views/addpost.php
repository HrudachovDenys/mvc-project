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
    
    <div class="addpost">
        <form class="form_addpost" method="post" action="../api/addpost">
            <input type="text" name="title" class="addpost_title" placeholder="Название поста" required>
            <select class="addpost_category" name="category">
                <?php foreach(Module_Profile::instance()->getCategories() as $category) :?>
                <?php echo "<option value='" . $category["id"] . "'>" . $category["category"] . "</option>"?>
                <?php endforeach; ?>
            </select>
            <input type="text" name="url_title" class="addpost_url_title" placeholder="URL картинки поста" required>
            <textarea class="addpost_text" name="text"></textarea>
            <input type="submit" name="action" value="Просмотреть" onclick="preview_click()">
            <input type="submit" name="action" value="Добавить пост" onclick="addpost_click()">
        </form>
    </div>
</div>
