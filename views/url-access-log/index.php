<?php

use app\models\UrlAccessLog;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\UrlAccessLogSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Url Access Logs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="url-access-log-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'shortUrl.original_url',
            'access_ip',
            'accessed_at',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, UrlAccessLog $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
