<div class="modal">
    <button class="modal__close" type="button" name="button">Закрыть</button>

    <h2 class="modal__heading">Добавление проекта</h2>

    <form class="form"  action="?project" method="post">
        <div class="form__row">
            <label class="form__label" for="project_name">Название <sup>*</sup></label>

            <input class="form__input <?php
            if (isset($errors['project_name'])) {
                print('form__input--error');
            }
            ?>" type="text" name="project_name" id="project_name" value="<?php
            if (isset($get_data['project_name'])) {
                print(htmlspecialchars($get_data['project_name']));
            }
            ?>" placeholder="Введите название проекта">
            <?php
            if (isset($errors)) {
                print('<p class="form__message">Введите название проекта</p>');
            }
            ?>
        </div>

        <div class="form__row form__row--controls">
            <input class="button" type="submit" name="" value="Добавить">
        </div>
    </form>
</div>