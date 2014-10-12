<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMetaDataAttributesToMediaTable extends Migration {

	private $table = 'media';

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table($this->table, function($table)
		{
			$table->string('metadata_type', 255);
			$table->integer('metadata_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table($this->table, function($table)
		{
			$table->dropColumn(['metadata_type', 'metadata_id']);
		});
	}

}
