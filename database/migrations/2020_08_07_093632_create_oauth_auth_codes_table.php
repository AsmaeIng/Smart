<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOauthAuthCodesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('oauth_auth_codes', function(Blueprint $table)
		{
			$table->string('id', 100)->primary();
			$table->bigInteger('user_id')->unsigned()->index();
			$table->bigInteger('client_id')->unsigned();
			$table->text('scopes', 65535)->nullable();
			$table->boolean('revoked');
			$table->dateTime('expires_at')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('oauth_auth_codes');
	}

}
