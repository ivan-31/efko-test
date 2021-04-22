<?php
// Представление для Vacation

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\web\View;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\jui\DatePicker;

$user = Yii::$app->user->identity;

// Регистрируем скрипт JS (обработка формы через Ajax и др.)
$this->registerJsFile('@web/js/site.js', ['depends' => 'yii\web\YiiAsset']);

$this->title = 'График отпусков';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-vacation">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php if ($user->role == 'employee'): // Если у нас рядовой сотрудник ?>
        <h3>Мой отпуск</h3>
        <div id="messages1" role="alert"></div>
    <?php if ($model->fixed): // Отпуск утвержден руководителем ?>
        <div>
            <p>
                С <b><?= \Yii::$app->formatter->asDate($model->date_start) ?></b> по <b><?= \Yii::$app->formatter->asDate($model->date_end) ?></b> (утвержден руководителем).
            </p>
        </div>
    <?php else: // Отпуск не утвержден, выводим форму (обрабатывается через Ajax) ?>
    <?php
    $form = ActiveForm::begin(['id' => 'form-vacation', 'options' => ['class' => 'form-inline'], 'enableAjaxValidation' => true, 'validationUrl' => Url::to(['validate-vacation']),]); // если через pjax, добавить 'data' => ['pjax' => true]
    ?>
    <div class="row">
        <div class="col-sm-4 col-lg-3">
            <?= $form->field($model, 'date_start')->textInput()->widget(DatePicker::classname(), [
                'language' => 'ru',
                'dateFormat' => 'yyyy-MM-dd',
                'options' => [
                    'style' => 'width:100px'
                ],
                'clientOptions' => [
                    'minDate' => 1,
                ],
            ]);?>
        </div>
        <div class="col-sm-4 col-lg-3">
            <?= $form->field($model, 'date_end')->textInput()->widget(DatePicker::classname(), [
                'language' => 'ru',
                'dateFormat' => 'yyyy-MM-dd',
                'options' => [
                    'style' => 'width:100px'
                ],
                'clientOptions' => [
                        'minDate' => 1,
                ],
            ]);?>
        </div>
        <?= $form->field($model, 'user_id')->hiddenInput(['value' => $user->getId()])->label('');?>
        <div class="col-sm-4 col-lg-6">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary', 'name' => 'vacation-button']);?>
        </div>
    <?php ActiveForm::end();?>
    <?php endif; ?>
        <hr style="margin-top: 45px">
        <h3>Отпуска сотрудников</h3>
    </div>
    <?php endif; ?>

    <div class="row">
        <div class="col">
            <div id="messages2" role="alert"></div>

    <?php
        Pjax::begin(['id' => 'gridv']);
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            // сообщение при отсутствии данных
            'emptyText' => 'Нет данных для отображения.',
            // настройки таблицы
            'tableOptions' => [
                'class' => 'table table-striped table-bordered'
            ],
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'], // NN по-порядку
                [
                    'attribute' => 'user.full_name',
                    'format' => 'text',
                    'label' => 'ФИО сотрудника',
                ],
                [
                    'attribute' => 'date_start',
                    'format' => 'date', // 'format' =>  ['date', 'dd.MM.YYYY'],
                ],
                [
                    'attribute' => 'date_end',
                    'format' => 'date', // 'format' =>  ['date', 'dd.MM.YYYY'],
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'visible' => $user->role == 'manager' ? true : false,
                    'contentOptions' => ['data-method' => 'post'], // del
                    'header' => '',
                    'template' => '{vacation}',
                    'buttons' => [
                        'vacation' => function ($url, $model, $key) {
                            if ($model->fixed) {
                                return Html::tag('span', '', ['class' => 'glyphicon glyphicon glyphicon-ok', 'title' => 'Даты утверждены', 'style' => 'color:green']);
                            }
                            return Html::button(
                                '<span class="glyphicon glyphicon glyphicon-ok"></span>',
                                ['onclick' => 'fixVacation("'.$url.'",'.$model->id.')',
                                 'title' => 'Утвердить даты отпуска',
                                 'style' => 'color:#337ab7;border:1px solid #337ab7']);
                        },
                    ],
                ],
            ],
        ]);
        Pjax::end();
    ?>
        </div>
    </div>
</div>
