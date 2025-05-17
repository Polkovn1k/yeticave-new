<?=$categories_template;?>
<section class="lot-item container">
    <h2><?=$lot['lot_name'];?></h2>
    <div class="lot-item__content">
        <div class="lot-item__left">
            <div class="lot-item__image">
                <img src="../uploads/<?=$lot['img'];?>" width="730" height="548" alt>
            </div>
            <p class="lot-item__category">Категория: <span><?=$lot['category'];?></span></p>
            <p class="lot-item__description"><?=$lot['description'];?></p>
        </div>
        <div class="lot-item__right">
            <?php if ($user_name): ?>
                <div class="lot-item__state">
                <?php $timeleft_arr = get_time_left(htmlspecialchars($lot['end_date']));?>
                <div class="lot-item__timer timer <?=$timeleft_arr[0] == 0 ? 'timer--finishing' : '';?>">
                    <?=$timeleft_arr[0];?>:<?=$timeleft_arr[1];?>
                </div>
                <div class="lot-item__cost-state">
                    <div class="lot-item__rate">
                        <span class="lot-item__amount">Текущая цена</span>
                        <span class="lot-item__cost"><?=price_format($lot['start_price']);?></span>
                    </div>
                    <div class="lot-item__min-cost">
                        Мин. ставка <span><?=price_format($lot['bet_step'], true);?></span>
                    </div>
                </div>
                <form class="lot-item__form" action="/lot.php?<?=htmlspecialchars(http_build_query($_GET));?>" method="post" autocomplete="off">
                    <?php $has_error = (count($errors) > 0); ?>
                    <p class="lot-item__form-item form__item <?=$has_error ? 'form__item--invalid' : '';?>">
                        <label for="cost">Ваша ставка</label>
                        <input id="cost" type="text" name="cost" placeholder="<?=$lot['bet_step'];?>">
                        <?php if ($has_error): ?>
                            <span class="form__error lot-item-error"><?=$errors[0];?></span>
                        <?php endif; ?>
                    </p>
                    <button type="submit" class="button">Сделать ставку</button>
                </form>
            </div>
            <?php endif ?>
            <?php if ($bets_count > 0): ?>
                <div class="history">
                <h3>История ставок (<span><?=$bets_count;?></span>)</h3>
                <table class="history__list">
                    <tbody>
                    <?php foreach ($bets as $bet): ?>
                        <tr class="history__item">
                            <td class="history__name"><?=$bet['name'];?></td>
                            <td class="history__price"><?=price_format($bet['price'], true);?></td>
                            <td class="history__time"><?=$bet['date'];?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif ?>
        </div>
    </div>
</section>
