<?=$categories_template;?>
<section class="lot-item container">
    <?php if (isset($add_text_content)): ?>
        <?=$add_text_content;?>
    <?php else: ?>
        <h2>Вы не вошли в систему</h2>
        <p>Чтобы просмотреть эту страницу, <a href="/login.php" class="link">войдите</a> или <a href="/sign-up.php" class="link">создайте аккаунт</a></p>
    <?php endif; ?>
</section>
