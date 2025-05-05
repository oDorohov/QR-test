<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\UrlAccessLog $model */

$this->title = 'Create Url Access Log';
$this->params['breadcrumbs'][] = ['label' => 'Url Access Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="url-access-log-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
