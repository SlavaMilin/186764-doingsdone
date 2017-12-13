<section class="content__side">
    <h2 class="content__side-heading">Проекты</h2>

    <nav class="main-navigation">
        <ul class="main-navigation__list">
            <?php foreach ($projects as $value): ?>
                <li class="main-navigation__list-item <?php if (intval($value['project_id']) === $category_page) echo 'main-navigation__list-item--active' ?>">
                    <a class="main-navigation__list-item-link" href="<?='/index.php?' . 'category_page=' . $value['project_id'];?>">
                        <?= htmlspecialchars($value['project_name']); ?>
                    </a>
                    <span class="main-navigation__list-item-count">
                        <?= htmlspecialchars(get_task_count($tasks, $value['project_id'])); ?>
                    </span>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>

    <a class="button button--transparent button--plus content__side-button" href="?project">Добавить проект</a>
</section>
<main class="content__main">
    <h2 class="content__main-heading">Список задач</h2>

    <form class="search-form" action="index.php" method="post">
        <input class="search-form__input" type="text" name="" value="" placeholder="Поиск по задачам">

        <input class="search-form__submit" type="submit" name="" value="Искать">
    </form>

    <div class="tasks-controls">
        <nav class="tasks-switch">
            <a href="?all_task" class="tasks-switch__item <?php isset($_GET['all_task']) ? print('tasks-switch__item--active') : print('');?>">Все задачи</a>
            <a href="?today_task" class="tasks-switch__item <?php isset($_GET['today_task']) ? print('tasks-switch__item--active') : print('');?>">Повестка дня</a>
            <a href="?tomorrow_task" class="tasks-switch__item <?php isset($_GET['tomorrow_task']) ? print('tasks-switch__item--active') : print('');?>">Завтра</a>
            <a href="?ended_task" class="tasks-switch__item <?php isset($_GET['ended_task']) ? print('tasks-switch__item--active') : print('');?>">Просроченные</a>
        </nav>

        <label class="checkbox">
            <a href="index.php?show_completed=<?php
                isset($_COOKIE['show_completed']) ? print((int)!(bool) $_COOKIE['show_completed']) : print(1);
            ?>">
                <input class="checkbox__input visually-hidden" type="checkbox" <?php
                if (isset($_COOKIE['show_completed']) ? (bool) $_COOKIE['show_completed'] : false) {echo 'checked';};
                ?>>

                <span class="checkbox__text">Показывать выполненные</span>
            </a>
        </label>
    </div>

    <table class="tasks">
        <?php foreach(show_complete_task(filtering_category_array($tasks, $projects, $category_page)) as $key => $value): ?>
            <tr class="tasks__item task <?php isset($value['date_finish']) ? print('task--completed') : print('');?>">
                <td class="task__select">
                    <label class="checkbox task__checkbox">
                        <input class="checkbox__input visually-hidden" type="checkbox">
                        <a href="?finish_task=<?=htmlspecialchars($value['task_id']) ?>&key=<?=$key?>">
                        <span class="checkbox__text">
                            <?php if ($value['task']) :?>
                            <?= htmlspecialchars($value['task']); ?>
                            <?php endif; ?>
                        </span>
                        </a>
                    </label>
                </td>
                <td class="task__file">
                    <?php if ($value['file_link']):?>
                        <a class="download-link" href="<?=htmlspecialchars(UPLOAD_DIR_PATH . $value['file_link']);?>"> <?=htmlspecialchars($value['file_link']);?></a>
                    <?php endif;?>
                </td>
                <td class="task__date">
                    <?php if ($value['date_deadline']) : ?>
                        <?= htmlspecialchars(date('d.m.Y', strtotime($value['date_deadline']))); ?>
                    <? endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</main>