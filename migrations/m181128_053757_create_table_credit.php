<?php

use yii\db\Migration;

class m181128_053757_create_table_credit extends Migration
{
	
	public function up()
	{
		$tableOptions = null;
		if ($this->db->driverName === 'mysql') {
			$tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
		}
		
		$this->createTable('{{%credit}}', [
			'value' => $this->primaryKey(),
		], $tableOptions);
		
	}
	
	public function down()
	{
		$this->dropTable('{{%credit}}');
	}
}
