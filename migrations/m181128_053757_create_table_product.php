<?php

use yii\db\Migration;

class m181128_053757_create_table_product extends Migration
{
	
	public function up()
	{
		$tableOptions = null;
		if ($this->db->driverName === 'mysql') {
			$tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
		}
		
		$this->createTable('{{%product}}', [
			'id' => $this->primaryKey(),
			'title' => $this->string()->notNull(),
			'count' => $this->integer()->notNull()->defaultValue('0'),
			'price' => $this->integer()->notNull()->defaultValue('0'),
		], $tableOptions);
		
	}
	
	public function down()
	{
		$this->dropTable('{{%product}}');
	}
}
