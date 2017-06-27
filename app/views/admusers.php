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
    <table class="adm_users">
        <thead>
            <tr>
                <td>User</td>
                <td>Status</td>
                <td>Posts</td>
                <td>Actions</td>
            </tr>
        </thead>
        <?php foreach (Module_Auth::instance()->getUsers() as $user) : ?>
        <tr>
            <td><?= $user['username']?></td>
            <td><?= Module_Auth::instance()->getRole($user['id'])?></td>
            <td><?= Module_Post::instance()->postsCount($user['id'])?></td>
            <td>
                <?php if(Module_Auth::instance()->getRole($user['id']) != 'blocked') : ?>
                <?php echo "<a href='" . Config::get('domain') . "api/adm_roleupdate/" . $user['id'] . '/blocked' . "'>Забанить</a>"; ?>
                <?php else : ?>
                <?php echo "<a href='" . Config::get('domain') . "api/adm_roleupdate/" . $user['id'] . '/user' . "'>Разбанить</a>"; ?>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach;?>
    </table>
</div>
