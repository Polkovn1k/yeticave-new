<nav class="nav">
    <ul class="nav__list container">
        <?php foreach ($categories as $category): ?>
            <li class="nav__item">
                <a href="/<?=$category['code'];?>.php"><?=$category['name'];?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>
<section class="lot-item container">
    <?php if (isset($add_text_content)): ?>
        <?=$add_text_content;?>
    <?php else: ?>
        <h2>Вы не вошли в систему</h2>
        <p>Чтобы просмотреть эту страницу, <a href="/login.php" class="link">войдите</a> или <a href="/sign-up.php" class="link">создайте аккаунт</a></p>
    <?php endif; ?>
</section>
