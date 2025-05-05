<?php
use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'Сервис коротких ссылок';
?>

<div class="site-index">
    <h1>Введите ссылку</h1>

    <div class="form-group">
        <input type="text" id="original-url" class="form-control" placeholder="https://example.com" />
    </div>

    <button id="submit-btn" class="btn btn-primary">ОК</button>

    <div id="result" class="mt-4"></div>
</div>

<?php
$checkUrl = Url::to(['site/create-short-link']);
$csrf = Yii::$app->request->getCsrfToken();

$js = <<<JS
$('#submit-btn').on('click', function() {
    var url = $('#original-url').val();

    $.ajax({
        url: '$checkUrl',
        type: 'POST',
        data: {
            url: url,
            _csrf: '$csrf'
        },
        success: function(data) {
            if (data.error) {
                $('#result').html('<div class="alert alert-danger">' + data.error + '</div>');
            } else {
                $('#result').html(
                    '<div class="alert alert-success">Короткая ссылка: <a href="' + data.shortUrl + '" target="_blank">' + data.shortUrl + '</a></div>' +
                    '<img src="' + data.qr + '" alt="QR Code" />'
                );
            }
        },
        error: function() {
            $('#result').html('<div class="alert alert-danger">Ошибка при запросе.</div>');
        }
    });
});
JS;

$this->registerJs($js);
?>
