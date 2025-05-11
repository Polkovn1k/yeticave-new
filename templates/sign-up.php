<?=$categories_template;?>
<form class="form container <?=(count($errors) > 0) ? 'form--invalid' : '';?>"
      action="/sign-up.php"
      method="post"
      autocomplete="off"
>
    <h2>Регистрация нового аккаунта</h2>
    <div class="form__item <?=isset($errors['email']) ? 'form__item--invalid' : '';?>">
        <label for="email">E-mail <sup>*</sup></label>
        <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?=$reg_data['email'] ?? '';?>">
        <span class="form__error">Введите e-mail</span>
    </div>
    <div class="form__item <?=isset($errors['password']) ? 'form__item--invalid' : '';?>">
        <label for="password">Пароль <sup>*</sup></label>
        <input id="password" type="password" name="password" placeholder="Введите пароль">
        <span class="form__error">Введите пароль</span>
    </div>
    <div class="form__item <?=isset($errors['name']) ? 'form__item--invalid' : '';?>">
        <label for="name">Имя <sup>*</sup></label>
        <input id="name" type="text" name="name" placeholder="Введите имя" value="<?=$reg_data['name'] ?? '';?>">
        <span class="form__error">Введите имя</span>
    </div>
    <div class="form__item <?=isset($errors['contacts']) ? 'form__item--invalid' : '';?>">
        <label for="message">Контактные данные <sup>*</sup></label>
        <textarea id="message" name="contacts" placeholder="Напишите как с вами связаться"><?=$reg_data['contacts'] ?? '';?></textarea>
        <span class="form__error">Напишите как с вами связаться</span>
    </div>
    <?php foreach ($errors as $error): ?>
        <span class="form__error form__error--bottom"><?=$error[0];?></span>
    <?php endforeach; ?>
    <button type="submit" class="button">Зарегистрироваться</button>
    <a class="text-link" href="/login.php">Уже есть аккаунт</a>
</form>
