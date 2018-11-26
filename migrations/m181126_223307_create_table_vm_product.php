<?php

use yii\db\Migration;

class m181126_223307_create_table_vm_product extends Migration
{
	
	public function up()
	{
		$tableOptions = null;
		if ($this->db->driverName === 'mysql') {
			$tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
		}
		
		$this->createTable('{{%vm_product}}', [
			'id' => $this->primaryKey(),
			'title' => $this->string()->notNull(),
			'count' => $this->integer()->notNull()->defaultValue('0'),
			'price' => $this->integer()->notNull()->defaultValue('0'),
		], $tableOptions);
		
	}
	
	public function down()
	{
		$this->dropTable('{{%vm_product}}');
	}
}
