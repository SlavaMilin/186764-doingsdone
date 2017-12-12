<div class="modal">
    <button class="modal__close" type="button" name="button">Закрыть</button>

    <h2 class="modal__heading">Добавление задачи</h2>

    <form class="form" action="index.php?form" method="post" enctype="multipart/form-data">
        <div class="form__row">
            <label class="form__label" for="task">Название <sup>*</sup></label>
            <?php if (isset($errors['task'])) {echo '<p class="form__message">Заполните это поле</p>';}?>
            <input class="form__input <?php if (isset($errors['task'])) {echo 'form__input--error';};?>" type="text" name="task" id="task" value="<?php if (isset($get_data)) {echo $get_data['task'];};?>" placeholder="Введите название">
        </div>

        <div class="form__row">
            <label class="form__label" for="project_id">Проект <sup>*</sup></label>
            <?php if (isset($errors['project_id'])) {echo '<p class="form__message">Заполните это поле</p>';}?>
            <select class="form__input form__input--select <?php if (isset($errors['project_id'])) {echo 'form__input--error';};?>" name="project_id" id="project_id">
                <?php foreach ($projects as $key => $value): ?>
                <?php if ($key === 0) {continue;}; ?>
                <option value="<?=$value['project_id']; ?>"><?=$value['project_name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form__row">
            <label class="form__label" for="date">Дата выполнения</label>
            <input class="form__input form__input--date" type="date" name="date_deadline" id="date" value="<?php if (isset($get_data)) echo $get_data['date'];?>" placeholder="Введите дату в формате ДД.ММ.ГГГГ">
        </div>

        <div class="form__row">
            <label class="form__label" for="preview">Файл</label>

            <div class="form__input-file">
                <input class="visually-hidden" type="file" name="file_link" id="preview" value="">

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