<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\UrlAccessLog $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="url-access-log-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'short_url_id')->textInput() ?>

    <?= $form->field($model, 'access_ip')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'accessed_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
