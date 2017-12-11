<div class="modal">
    <button class="modal__close" type="button" name="button">Закрыть</button>

    <h2 class="modal__heading">Вход на сайт</h2>

    <form class="form" action="index.php?login" method="post">
        <div class="form__row">
            <label class="form__label" for="email">E-mail <sup>*</sup></label>

            <input class="form__input form__input<?php
            if (isset($errors['email'])) {
                print('--error');
            }
            ?>"type="text" name="email" id="email" value="<?php if (isset($get_data['email'])) {print($get_data['email']);} ?>" placeholder="Введите e-mail">

            <?php
                if (isset($errors['email'])) {
                    print('<p class="form__message">E-mail введён некорректно</p>');
                }
            ?>
        </div>

        <div class="form__row">
            <label class="form__label" for="password">Пароль <sup>*</sup></label>

            <input class="form__input form__input<?php
                if (isset($errors['password'])) {
                    print('--error');
                }
            ?>" type="password" name="password" id="password" value="" placeholder="Введите пароль">
            <?php
            if (isset($errors['password'])) {
                print('<p class="form__message">Пароль введён некорректно</p>');
            }
            ?>
        </div>

        <div class="form__row form__row--controls">
            <input class="button" type="submit" name="" value="Войти">
        </div>
    </form>
</div>