<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\ShortUrl $model */

$this->title = 'Create Short Url';
$this->params['breadcrumbs'][] = ['label' => 'Short Urls', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="short-url-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
