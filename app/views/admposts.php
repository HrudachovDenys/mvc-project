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
                <td>Post</td>
                <td>Status</td>
                <td>User</td>
                <td>Actions</td>
            </tr>
        </thead>
        <?php foreach (Module_Post::instance()->getPosts() as $post) : ?>
        <tr>
            <td><?= $post['title']?></td>
            <td><?= Module_Post::instance()->getStatus($post['status_id'])?></td>
            <td><?= Module_Auth::instance()->getUser($post['user_id'])['username']?></td>
            <td>
                <?php echo "<a target='_blank' href='../post/view/" . $post['id'] . "'>Просмотр</a>&nbsp&nbsp" ?>
                <?php echo "<a href='../api/postpublish/" . $post['id'] . "/published'>Опубликовать</a>" ?>
            </td>
        </tr>
        <?php endforeach;?>
    </table>
</div>
