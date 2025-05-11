<nav class="nav">
    <ul class="nav__list container">
        <?php foreach ($categories as $category): ?>
            <li class="nav__item">
                <a href="/<?=$category['code'];?>.php"><?=$category['name'];?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>
<div class="container">
    <?php if (empty($search_query)): ?>
        <section class="lots">
            <h2>Введите название/описание лота</h2>
        </section>
    <?php elseif(count($lots) === 0): ?>
        <section class="lots">
            <h2>Ничего не найдено по вашему запросу</h2>
        </section>
    <?php else: ?>
        <section class="lots">
            <h2>Результаты поиска по запросу «<span><?=$search_query;?></span>»</h2>
            <ul class="lots__list">
                <?php foreach ($lots as $lot): ?>
                    <li class="lots__item lot">
                        <div class="lot__image">
                            <img src="/uploads/<?=$lot['img'];?>" width="350" height="260" alt="<?=$lot['name'];?>">
                        </div>
                        <div class="lot__info">
                            <span class="lot__category">Доски и лыжи</span>
                            <h3 class="lot__title"><a class="text-link" href="/lot.php?id=<?=$lot['id'];?>"><?=$lot['name'];?></a></h3>
                            <div class="lot__state">
                                <div class="lot__rate">
                                    <span class="lot__amount">Стартовая цена</span>
                                    <span class="lot__cost"><?=price_format($lot['start_price'], true);?></span>
                                </div>
                                <?php $timeleft_arr = get_time_left($lot['finish_time']);?>
                                <div class="lot__timer timer <?=$timeleft_arr[0] == 0 ? 'timer--finishing' : '';?>">
                                    <?=$timeleft_arr[0];?>:<?=$timeleft_arr[1];?>
                                </div>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>
        <ul class="pagination-list">
            <li class="pagination-item pagination-item-prev">
                <?php if ($page_number > 1): ?>
                    <a href="?search=<?=$search_query;?>&page=<?=$page_number - 1;?>">Назад</a>
                <?php else: ?>
                    <a>Назад</a>
                <?php endif; ?>
            </li>
            <?php for ($i = $start_page; $i <= $end_page; $i++): ?>
                <?php if ($i == $page_number): ?>
                    <li class="pagination-item pagination-item-active">
                        <a><?=$i;?></a>
                    </li>
                <?php else: ?>
                    <li class="pagination-item">
                        <a href="?search=<?=$search_query;?>&page=<?=$i;?>"><?=$i;?></a>
                    </li>
                <?php endif; ?>
            <?php endfor; ?>
            <li class="pagination-item pagination-item-next">
                <?php if ($page_number < $total_pages): ?>
                    <a href="?search=<?=$search_query;?>&page=<?=$page_number + 1;?>">Вперед</a>
                <?php else: ?>
                    <a>Вперед</a>
                <?php endif; ?>
            </li>
        </ul>
    <?php endif; ?>
</div>
