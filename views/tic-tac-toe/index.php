<?php
/* @var $this yii\web\View */
session_start();
use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>
<h1>Тестовое задание крестики-нолики</h1>

<p>
    <h2>Ответ сервера</h2>
    <div style="margin-bottom: 100px;" id="response" class="">
    <?php
    ref::config('expLvl', 5);
    if (!empty($response)){
        r($response);
    }
    ?>
    </div>
    <h2>Содержимое сессии</h2>
    <div><?=r($_SESSION['games'])?></div>

    <div class="clearfix"></div>
    <?php $form = ActiveForm::begin([
        'id' => 'start'
    ]); ?>

    <input name="startGame" type="hidden" value="true">


    <div class="form-group">
        <?= Html::submitButton('Начать игру', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>


<?php $form = ActiveForm::begin([
]); ?>
<p>
    Форма для получения состояния стола
</p>


<div class="form-group">

    <input name="getBoardCondition" type="hidden" value="true">
    <select name="idBoard">
        <?php
        if (!empty($_SESSION['games'])) {
            foreach ($_SESSION['games'] as $id => $game) {
                ?>
        <option value="<?=$id?>"><?=$id?></option>
        <?php
            }

        }
        ?>
    </select>
    <?= Html::submitButton('Получить состояние стола', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>

<?php $form = ActiveForm::begin([
]); ?>
<p>
    Форма для хода
</p>


<div class="form-group">

    <input name="move" type="hidden" value="true">
    <input name="x" placeholder="координата x">
    <input name="y" placeholder="координата y">
    <select name="idBoard">
        <?php
        if (!empty($_SESSION['games'])) {
            foreach ($_SESSION['games'] as $id => $game) {
                ?>
                <option value="<?=$id?>"><?=$id?></option>
                <?php
            }

        }
        ?>
    </select>

    <?= Html::submitButton('Сделать ход', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>


</p>


