<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "short_url".
 *
 * @property int $id
 *
 * @property UrlAccessLog[] $urlAccessLogs
 */
class ShortUrl extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'short_url';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
        ];
    }

    /**
     * Gets query for [[UrlAccessLogs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUrlAccessLogs()
    {
        return $this->hasMany(UrlAccessLog::class, ['short_url_id' => 'id']);
    }

}
