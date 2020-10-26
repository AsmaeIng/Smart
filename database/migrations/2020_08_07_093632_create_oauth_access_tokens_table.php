<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOauthAccessTokensTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('oauth_access_tokens', function(Blueprint $table)
		{
			$table->string('id', 100)->primary();
			$table->bigInteger('user_id')->unsigned()->nullable()->index();
			$table->bigInteger('client_id')->unsigned();
			$table->string('name')->nullable();
			$table->text('scopes', 65535)->nullable();
			$table->boolean('revoked');
			$table->timestamps();
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
		Schema::drop('oauth_access_tokens');
	}

}
