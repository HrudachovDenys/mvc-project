<div class="post_choose_blocks">
    <?php foreach (Module_Post::instance()->getPosts() as $post) : ?>
        <?php if(Module_Post::instance()->getStatus($post['status_id']) == 'published') : ?>
            <?php echo "<a href='post/view/" . $post['id'] . "'><div class='post_choose_block'>"; ?>
            <?php echo "<h1>" . $post['title'] . "</h1>"; ?>
            <?php echo "<img src='" . $post['url_title'] . "'></div></a>"; ?>
        <?php endif; ?>
    <?php endforeach; ?>
</div>