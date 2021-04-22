<?php

/* @var $this yii\web\View */

$this->title = 'Тестовый проект';
?>
<div class="site-index">
    <h2>Тестовый проект <a href="mailto:ivan@shkuratov.com">Ивана Шкуратова</a></h2>
    <h3>Задание:</h3>
    <pre>
        Требуется выполнить задание на Yii2 и прислать нам ссылку на ваш репозиторий.
Если Вы не знакомы с Yii2, то можете выполнить задачу на удобном для вас фреймворке.
Требуется выполнить задание и прислать нам ссылку на ваш репозиторий.
Либо, если вы желаете использовать другой фреймворк то можете написать на php с ипользованием MVC.

Задача:
Нужно сделать простую систему.
Есть рядовой сотрудник, который может:
•	ввести начало и конец отпуска;
•	посмотреть какие даты отпусков у других сотрудников.
•	скорректировать свои даты.
Есть Руководитель, который может:
•	так же посмотреть какие даты ввели сотрудники.
•	поставить признак, что данные по отпуску конкретного сотрудника зафиксированы.
После этого сотрудник не может скорректировать свои даты
Не обязательно (если желаете лучше продемонстрировать свои умения)
•	Дополнительный функционал для страницы списка отпусков
•	Оформление readme и других вспомогательный решений
    </pre>

    <h3>Системные требования</h3>
    <p><b>Обычные для фрейморка Yii2 (advanced).</b></p>
    <p>- Нет специфических требований к ОС, веб-серверу, версии PHP, БД и т.п.</p>
    <p>- Необходим установленный Composer.</p>

    <h3>Развертывание проекта</h3>
    <p>- Склонировать проект из репозитория GIT (https://github.com/ivan-31/efko-test.git) в папку на локальном веб-сервере</p>
    <p>- В папке проекта выполнить инициализацию Yii <i>> php init </i> (терминал)</p>
    <p>- Установить зависимые пакеты <i>> composer install</i> (терминал)</p>
    <p>- Добавить настройки доступа к существующей БД в файле <i>common/config/main-local.php</i></p>
    <p>- Применить миграции БД <i>> php yii migrate</i> (терминал)</p>
    <p style="font-size: smaller">Будут созданы таблицы:<br>
        а) migration<br>
        b) user<br>
        c) vacation
    </p>
    <p>- Перейти на страницу <i>ВАША_ПАПКА/frontend/web/index.php</i>, зарегиcтрироваться и выполнить вход.</p>
    <p style="font-size: smaller">(email может быть ненастоящим, но должен соотв. формату)
    </p>

    <h3>Что сделано:</h3>
    <p>- Регистрация пользователей с выбором роли (рядовой сотрудник или руководитель) и их логин в системе.</p>
    <p>- Единая страница "График отпусков", где сотрудники могут задать даты своих отпусков,
        исправить эти даты (пока они не зафиксированы руководителем), посмотреть даты отпусков других сотрудников.</p>
    <p>- Руководитель там же может зафиксировать даты отпусков каждого сотрудника (однократно) и просматривать график отпусков.</p>
    <p>- Валидация вводимых данных на фронт- и бэк-энде по единым правилам,
    исключающим даты в прошлом, неправильный формат дат, неправильное соотношение дат, подделку передаваемых данных.</p>
    <p>- Для обмена данными с сервером используется Аjax.</p>
    <p>- Учтена ситуация утверждения дат сотрудника уже после того, как он загрузил страницу (его данные не будут сохранены).</p>
    <p>- Учтена возможность одновременной работы с графиком нескольких пользователей в роли руководителей (одну запись может зафиксировать только один руководитель).</p>
    <p>- Использованы виджеты, позволяющие удобно выбирать даты, сортировать график отпусков сотрудников, выводить график с пагинацией.</p>
    <p>- Удобная фиксация дат руководителем в один клик с частичным обновлением страницы при помощи pjax.</p>

    <h3>Что не сделано (для упрощения реализации):</h3>
    <p>- Админ. панель и роль администратора, который может управлять др. пользователями.</p>
    <p>- ЧПУ (ибо не знаю, в каком окружении будет развертываться проект).</p>
    <p>- Верификация email при регистрации и восстановление пароля по email (отключено).</p>
    <p>- Возможность отменить фиксацию дат руководителя из веб-интерфейса.</p>

    <h3>Я попытался максимально следовать парадигме и тех.средствам, которые предлагает Yii2.</h3>
</div>
