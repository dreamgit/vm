<?php

use yii\db\Migration;

class m181127_222233_create_table_coin extends Migration
{
	
	public function up()
	{
		$tableOptions = null;
		if ($this->db->driverName === 'mysql') {
			$tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
		}
		
		$this->createTable('{{%coin}}', [
			'id' => $this->primaryKey(),
			'title' => $this->string()->notNull(),
			'value' => $this->integer()->notNull(),
		], $tableOptions);
		
	}
	
	public function down()
	{
		$this->dropTable('{{%coin}}');
	}
}
