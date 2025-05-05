<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%utl_access_log}}`.
 */
class m250505_174458_create_utl_access_log_table extends Migration
{
    /**
     * {@inheritdoc}
     */
	public function safeUp()
    {
        $this->createTable('{{%url_access_log}}', [
            'id' => $this->primaryKey(),
            'short_url_id' => $this->integer()->notNull(),
            'access_ip' => $this->string(45),
            'accessed_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        // Добавим внешний ключ
        $this->addForeignKey(
            'fk-url_access_log-short_url_id',
            '{{%url_access_log}}',
            'short_url_id',
            '{{%short_url}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-url_access_log-short_url_id', '{{%url_access_log}}');
        $this->dropTable('{{%url_access_log}}');
    }
}
