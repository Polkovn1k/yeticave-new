<?php extract($lot);?>
<?=$categories_template;?>
<form class="form form--add-lot container <?=(count($errors) > 0) ? 'form--invalid' : '';?>"
      action="/add.php"
      method="post"
      enctype="multipart/form-data"
>
    <h2>Добавление лота</h2>
    <div class="form__container-two">
        <div class="form__item <?=isset($errors['lot_name']) ? 'form__item--invalid' : '';?>">
            <label for="lot-name">Наименование <sup>*</sup></label>
            <input id="lot-name" type="text" name="lot_name" placeholder="Введите наименование лота" value="<?=$lot['lot_name'] ?? '';?>">
            <span class="form__error">Введите наименование лота</span>
        </div>
        <div class="form__item <?=isset($errors['category']) ? 'form__item--invalid' : '';?>">
            <label for="category">Категория <sup>*</sup></label>
            <select id="category" name="category">
                <option value selected readonly>Выберите категорию</option>
                <?php foreach ($categories as $category): ?>
                    <option
                            value="<?=$category['id'];?>"
                            <?=(isset($lot['category']) && $lot['category'] === $category['id']) ? 'selected' : '';?>
                    ><?=$category['name'];?></option>
                <?php endforeach ?>
            </select>
            <span class="form__error">Выберите категорию</span>
        </div>
    </div>
    <div class="form__item form__item--wide <?=isset($errors['lot_description']) ? 'form__item--invalid' : '';?>">
        <label for="message">Описание <sup>*</sup></label>
        <textarea id="message" name="lot_description" placeholder="Напишите описание лота"><?=$lot['lot_description'] ?? '';?></textarea>
        <span class="form__error">Напишите описание лота</span>
    </div>
    <div class="form__item form__item--file <?=isset($errors['lot_img']) ? 'form__item--invalid' : '';?>">
        <label>Изображение <sup>*</sup></label>
        <div class="form__input-file">
            <input class="visually-hidden" type="file" id="lot-img" value="" name="lot_img">
            <label for="lot-img">
                Добавить
            </label>
        </div>
    </div>
    <div class="form__container-three">
        <div class="form__item form__item--small <?=isset($errors['lot_rate']) ? 'form__item--invalid' : '';?>">
            <label for="lot-rate">Начальная цена <sup>*</sup></label>
            <input id="lot-rate" type="text" name="lot_rate" placeholder="0" value="<?=$lot['lot_rate'] ?? '';?>">
            <span class="form__error">Введите начальную цену</span>
        </div>
        <div class="form__item form__item--small <?=isset($errors['lot_step']) ? 'form__item--invalid' : '';?>">
            <label for="lot-step">Шаг ставки <sup>*</sup></label>
            <input id="lot-step" type="text" name="lot_step" placeholder="0" value="<?=$lot['lot_step'] ?? '';?>">
            <span class="form__error">Введите шаг ставки</span>
        </div>
        <div class="form__item <?=isset($errors['lot_date']) ? 'form__item--invalid' : '';?>">
            <label for="lot-date">Дата окончания торгов <sup>*</sup></label>
            <input class="form__input-date" id="lot-date" type="text" name="lot_date" placeholder="Введите дату в формате ГГГГ-ММ-ДД" value="<?=$lot['lot_date'] ?? '';?>">
            <span class="form__error">Введите дату завершения торгов</span>
        </div>
    </div>
    <?php foreach ($errors as $error): ?>
        <span class="form__error form__error--bottom"><?=$error[0];?></span>
    <?php endforeach; ?>
    <button type="submit" class="button">Добавить лот</button>
</form>
