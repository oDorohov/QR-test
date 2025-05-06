<?php

namespace app\controllers;

use app\models\UrlAccessLog;
use app\models\UrlAccessLogSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UrlAccessLogController implements the CRUD actions for UrlAccessLog model.
 */
class UrlAccessLogController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all UrlAccessLog models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new UrlAccessLogSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

  
}
