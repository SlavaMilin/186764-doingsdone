<div class="modal">
    <button class="modal__close" type="button" name="button">Закрыть</button>

    <h2 class="modal__heading">Добавление задачи</h2>

    <form class="form"  action="index.php" method="post">
        <div class="form__row">
            <label class="form__label" for="name">Название <sup>*</sup></label>
            <?php if (isset($errors['name'])) echo '<br><span style="color:red">Заполните это поле</span>'?>
            <input class="form__input <?php if (isset($errors['name'])) echo 'form__input--error'?>" type="text" name="name" id="name" value="<?php if (isset($get_data)) echo $get_data['name'];?>" placeholder="Введите название">
        </div>

        <div class="form__row">
            <label class="form__label" for="project">Проект <sup>*</sup></label>

            <select class="form__input form__input--select" name="project" id="project">
                <?php foreach ($projects as $value): ?>
                <?php if ($value === 'Все') continue; ?>
                <option value="<?=$value; ?>"><?=$value; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form__row">
            <label class="form__label" for="date">Дата выполнения</label>
            <?php if (isset($errors['date'])) echo '<br><span style="color:red">Заполните это поле</span>'?>
            <input class="form__input form__input--date <?php if (isset($errors['date'])) echo 'form__input--error'?>" type="date" name="date" id="date" value="<?php if (isset($get_data)) echo $get_data['date'];?>" placeholder="Введите дату в формате ДД.ММ.ГГГГ">
        </div>

        <div class="form__row">
            <label class="form__label" for="preview">Файл</label>

            <div class="form__input-file">
                <input class="visually-hidden" type="file" name="preview" id="preview" value="">

                <label class="button button--transparent" for="preview">
                    <span>Выберите файл</span>
                </label>
            </div>
        </div>

        <div class="form__row form__row--controls">
            <input class="button" type="submit" name="" value="Добавить">
        </div>
    </form>
</div>