<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "url_access_log".
 *
 * @property int $id
 * @property int $short_url_id
 * @property string|null $access_ip
 * @property string|null $accessed_at
 *
 * @property ShortUrl $shortUrl
 */
class UrlAccessLog extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'url_access_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['access_ip'], 'default', 'value' => null],
            [['short_url_id'], 'required'],
            [['short_url_id'], 'integer'],
            [['accessed_at'], 'safe'],
            [['access_ip'], 'string', 'max' => 45],
            [['short_url_id'], 'exist', 'skipOnError' => true, 'targetClass' => ShortUrl::class, 'targetAttribute' => ['short_url_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'short_url_id' => 'Short Url ID',
            'access_ip' => 'Access Ip',
            'accessed_at' => 'Accessed At',
        ];
    }

    /**
     * Gets query for [[ShortUrl]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getShortUrl()
    {
        return $this->hasOne(ShortUrl::class, ['id' => 'short_url_id']);
    }

}
