<?php

use yii\db\Migration;

class m181127_222233_create_table_vm_coin extends Migration
{
	
	public function up()
	{
		$tableOptions = null;
		if ($this->db->driverName === 'mysql') {
			$tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
		}
		
		$this->createTable('{{%vm_coin}}', [
			'id' => $this->primaryKey(),
			'coin_id' => $this->integer(),
			'count' => $this->integer()->notNull()->defaultValue('0'),
		], $tableOptions);
		
		$this->createIndex('vm_coin_coin_id_uindex', '{{%vm_coin}}', 'coin_id', true);
		$this->addForeignKey('vm_coin_coin_id_fk', '{{%vm_coin}}', 'coin_id', '{{%coin}}', 'id', 'SET NULL', 'CASCADE');
	}
	
	public function down()
	{
		$this->dropTable('{{%vm_coin}}');
	}
}
