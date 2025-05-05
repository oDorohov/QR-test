<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\UrlAccessLog $model */

$this->title = 'Update Url Access Log: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Url Access Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="url-access-log-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
