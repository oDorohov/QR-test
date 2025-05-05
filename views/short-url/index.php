<?php

use app\models\ShortUrl;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\SortUrlSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Short Urls';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="short-url-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Short Url', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'original_url:ntext',
            'short_code',
            'created_at',
			[
				'attribute' => 'hits_count',
				'label' => 'Количество переходов',
				'value' => function ($model) {
					return $model->hits_count;
				},
			],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, ShortUrl $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
