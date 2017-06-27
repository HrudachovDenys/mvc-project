<div class="post_section">
    <h1 class="post_title"><?= Module_Post::instance()->getPost(app::getRouter()->getParams()[0])['title']?></h1>
    <?php echo "<img class='post_title_img' src='" . Module_Post::instance()->getPost(app::getRouter()->getParams()[0])['url_title'] . "'>";?>
    <div class="post_text"><?= Module_Post::instance()->getPost(app::getRouter()->getParams()[0])['text']?></div>
</div>
