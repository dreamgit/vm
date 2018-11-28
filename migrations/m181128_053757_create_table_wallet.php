<?php

use yii\db\Migration;

class m181128_053757_create_table_wallet extends Migration
{
	
	public function up()
	{
		$tableOptions = null;
		if ($this->db->driverName === 'mysql') {
			$tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
		}
		
		$this->createTable('{{%wallet}}', [
			'id' => $this->primaryKey(),
			'coin_id' => $this->integer(),
			'count' => $this->integer()->notNull()->defaultValue('0'),
			'type' => $this->string()->notNull()->defaultValue('user'),
		], $tableOptions);
		
		$this->createIndex('wallet_coin_id_type_uindex', '{{%wallet}}', ['coin_id', 'type'], true);
		$this->addForeignKey('wallet_coin_id_fk', '{{%wallet}}', 'coin_id', '{{%coin}}', 'id', 'SET NULL', 'CASCADE');
	}
	
	public function down()
	{
		$this->dropTable('{{%wallet}}');
	}
}
