<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\models\ShortUrl; // Модель для коротких ссылок
use app\models\UrlAccessLog; // Модель для истории переходов

class RedirectController extends Controller
{
    // Экшен редиректа по короткой ссылке
    public function actionIndex($code)
    {
        // Ищем короткую ссылку по хешу
        $shortUrl = ShortUrl::findOne(['short_code' => $code]);

        if (!$shortUrl) {
            throw new NotFoundHttpException('Короткая ссылка не найдена.');
        }

        // Записываем информацию о переходе (IP, время)
        $history = new UrlAccessLog();
        $history->short_url_id = $shortUrl->id;
        $history->access_ip = Yii::$app->request->userIP;  
        $history->accessed_at = date('Y-m-d H:i:s');
        $history->save();

        // Редирект на оригинальный URL
        return $this->redirect($shortUrl->original_url);
    }
}
