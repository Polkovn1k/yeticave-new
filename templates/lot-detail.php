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
                <form class="lot-item__form" action="https://echo.htmlacademy.ru" method="post" autocomplete="off">
                    <!--TODO надо поставить form__item--invalid, если не заполнили какое-то поле-->
                    <p class="lot-item__form-item form__item">
                        <label for="cost">Ваша ставка</label>
                        <input id="cost" type="text" name="cost" placeholder="<?=$lot['bet_step'];?>">
                        <span class="form__error">Введите наименование лота</span>
                    </p>
                    <button type="submit" class="button">Сделать ставку</button>
                </form>
            </div>
            <?php endif ?>
            <div class="history">
                <h3>История ставок (<span>10</span>)</h3>
                <table class="history__list">
                    <tbody><tr class="history__item">
                        <td class="history__name">Иван</td>
                        <td class="history__price">10 999 р</td>
                        <td class="history__time">5 минут назад</td>
                    </tr>
                    <tr class="history__item">
                        <td class="history__name">Константин</td>
                        <td class="history__price">10 999 р</td>
                        <td class="history__time">20 минут назад</td>
                    </tr>
                    <tr class="history__item">
                        <td class="history__name">Евгений</td>
                        <td class="history__price">10 999 р</td>
                        <td class="history__time">Час назад</td>
                    </tr>
                    <tr class="history__item">
                        <td class="history__name">Игорь</td>
                        <td class="history__price">10 999 р</td>
                        <td class="history__time">19.03.17 в 08:21</td>
                    </tr>
                    <tr class="history__item">
                        <td class="history__name">Енакентий</td>
                        <td class="history__price">10 999 р</td>
                        <td class="history__time">19.03.17 в 13:20</td>
                    </tr>
                    <tr class="history__item">
                        <td class="history__name">Семён</td>
                        <td class="history__price">10 999 р</td>
                        <td class="history__time">19.03.17 в 12:20</td>
                    </tr>
                    <tr class="history__item">
                        <td class="history__name">Илья</td>
                        <td class="history__price">10 999 р</td>
                        <td class="history__time">19.03.17 в 10:20</td>
                    </tr>
                    <tr class="history__item">
                        <td class="history__name">Енакентий</td>
                        <td class="history__price">10 999 р</td>
                        <td class="history__time">19.03.17 в 13:20</td>
                    </tr>
                    <tr class="history__item">
                        <td class="history__name">Семён</td>
                        <td class="history__price">10 999 р</td>
                        <td class="history__time">19.03.17 в 12:20</td>
                    </tr>
                    <tr class="history__item">
                        <td class="history__name">Илья</td>
                        <td class="history__price">10 999 р</td>
                        <td class="history__time">19.03.17 в 10:20</td>
                    </tr>
                    </tbody></table>
            </div>
        </div>
    </div>
</section>
