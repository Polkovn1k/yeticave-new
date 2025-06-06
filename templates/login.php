<?=$categories_template;?>
<form class="form container <?=(count($errors) > 0) ? 'form--invalid' : '';?>"
      action="/login.php"
      method="post"
      autocomplete="off"
>
    <h2>Вход</h2>
    <div class="form__item <?=isset($errors['email']) ? 'form__item--invalid' : '';?>">
        <label for="email">E-mail <sup>*</sup></label>
        <input id="email" type="text" name="email" placeholder="Введите e-mail">
        <span class="form__error">Введите e-mail</span>
    </div>
    <div class="form__item form__item--last <?=isset($errors['password']) ? 'form__item--invalid' : '';?>">
        <label for="password">Пароль <sup>*</sup></label>
        <input id="password" type="password" name="password" placeholder="Введите пароль">
        <span class="form__error">Введите пароль</span>
    </div>
    <?php foreach ($errors as $error): ?>
        <span class="form__error form__error--bottom"><?=$error[0];?></span>
    <?php endforeach; ?>
    <button type="submit" class="button">Войти</button>
</form>
