<section class="content__side">
    <h2 class="content__side-heading">Проекты</h2>

    <nav class="main-navigation">
        <ul class="main-navigation__list">
            <?php foreach ($projects as $key => $value): ?>
                <li class="main-navigation__list-item
                            <?php if ($key === 0): ?>
                                main-navigation__list-item--active
                            <?php endif; ?>">
                    <a class="main-navigation__list-item-link" href="#">
                        <?= htmlspecialchars($value); ?>
                    </a>
                    <span class="main-navigation__list-item-count">
                        <?= htmlspecialchars(get_task_count($tasks, $value)); ?>
                    </span>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>

    <a class="button button--transparent button--plus content__side-button" href="#">Добавить проект</a>
</section>
<main class="content__main">
    <h2 class="content__main-heading">Список задач</h2>

    <form class="search-form" action="index.html" method="post">
        <input class="search-form__input" type="text" name="" value="" placeholder="Поиск по задачам">

        <input class="search-form__submit" type="submit" name="" value="Искать">
    </form>

    <div class="tasks-controls">
        <nav class="tasks-switch">
            <a href="/" class="tasks-switch__item tasks-switch__item--active">Все задачи</a>
            <a href="/" class="tasks-switch__item">Повестка дня</a>
            <a href="/" class="tasks-switch__item">Завтра</a>
            <a href="/" class="tasks-switch__item">Просроченные</a>
        </nav>

        <label class="checkbox">
            <a href="/">
                <!--добавить сюда аттрибут "checked", если переменная $show_complete_tasks равна единице-->
                <input class="checkbox__input visually-hidden" type="checkbox">

                <span class="checkbox__text">Показывать выполненные</span>
            </a>
        </label>
    </div>

    <table class="tasks">
        <?php foreach($tasks as $key => $value): ?>
            <tr class="tasks__item task
            <?php if ($value['status'] === 'Да'): ?>
                task--completed
            <?php endif; ?>">
                <td class="task__select">
                    <label class="checkbox task__checkbox">
                        <input class="checkbox__input visually-hidden" type="checkbox">
                        <a href="/">
                            <span class="checkbox__text">
                                <?= htmlspecialchars($value['task']); ?>
                            </span>
                        </a>
                    </label>
                </td>

                <td class="task__file">
                </td>

                <td class="task__date">
                    <?= htmlspecialchars($value['date']); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</main>