<nav class="nav">
    <ul class="nav__list container">
        <?php foreach ($categories as $category): ?>
            <?php if (isset($category_type) && $category_type === $category['code']): ?>
                <li class="nav__item nav__item--current">
                    <a><?=$category['name'];?></a>
                </li>
            <?php else: ?>
                <li class="nav__item">
                    <a href="/category.php?category_type=<?=$category['code'];?>"><?=$category['name'];?></a>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>
</nav>
