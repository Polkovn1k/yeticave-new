<?=$categories_template;?>
<section class="rates container">
    <h2>Мои ставки</h2>
    <table class="rates__list">
        <tbody>
        <?php foreach ($my_bets as $bet): ?>
            <tr class="rates__item">
                <td class="rates__info">
                    <div class="rates__img">
                        <img src="../uploads/<?=$bet['img'];?>" width="54" height="40" alt="Сноуборд">
                    </div>
                    <h3 class="rates__title"><a href="lot.html"><?=$bet['lot_name'];?></a></h3>
                </td>
                <td class="rates__category"><?=$bet['finish_time'];?></td>
                <td class="rates__timer">
                    <?php $timeleft_arr = get_time_left(htmlspecialchars($bet['finish_time']));?>
                    <div class="timer <?=$timeleft_arr[0] == 0 ? 'timer--finishing' : '';?>">
                        <?=$timeleft_arr[0];?>:<?=$timeleft_arr[1];?>
                    </div>
                </td>
                <td class="rates__price"><?=price_format($bet['max_bets'], true);?></td>
                <td class="rates__time">
                    -
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody></table>
</section>
