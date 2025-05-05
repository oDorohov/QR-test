<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\ShortUrl;
use yii\helpers\Url;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
	
    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
	
	public function actionCreateShortLink()
	{
		Yii::$app->response->format = Response::FORMAT_JSON;
		$url = Yii::$app->request->post('url');

		// Валидация URL
		if (!filter_var($url, FILTER_VALIDATE_URL)) {
			return ['error' => 'Невалидный URL'];
		}

		// Проверка доступности (HEAD-запрос)
		$context = stream_context_create([
			'http' => [
				'method'  => 'HEAD',
				'timeout' => 3, // таймаут в секундах
			]
		]);

		$headers = @get_headers($url, 1, $context);
		if (!$headers || strpos($headers[0], '200') === false) {
			return ['error' => 'Ссылка недоступна'];
		}

		// Генерация короткого кода
		$shortCode = Yii::$app->security->generateRandomString(6);

		// Убедимся в уникальности
		while (ShortUrl::find()->where(['short_code' => $shortCode])->exists()) {
			$shortCode = Yii::$app->security->generateRandomString(6);
		}

		// Сохраняем
		$model = new ShortUrl();
		$model->original_url = $url;
		$model->short_code = $shortCode;
		$model->created_at = date('Y-m-d H:i:s');

		if (!$model->save()) {
			return ['error' => 'Ошибка при сохранении в базу'];
		}

		// Генерация абсолютной короткой ссылки
		$shortUrl = Url::to(['/redirect', 'code' => $shortCode], true);

		// Генерация QR-кода
		$qr = QrCode::create($shortUrl);
		$writer = new PngWriter();
		$result = $writer->write($qr);

		$qrTempPath = Yii::getAlias('@webroot') . "/qr/{$shortCode}.png";
		$qrWebPath = Yii::getAlias('@web') . "/qr/{$shortCode}.png";
		file_put_contents($qrTempPath, $result->getString());

		return [
			'shortUrl' => $shortUrl,
			'qr' => $qrWebPath
		];
	}
}
