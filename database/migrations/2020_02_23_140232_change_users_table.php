<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Users',function(Blueprint $table){
          $table->renameColumn('name','ten');
          $table->renameColumn('email','sdt');
          $table->boolean('is_active')->default(0);

          $table->dropColumn('email_verified_at');

        });
        Schema::rename('Users', 'NguoiBan');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::rename('NguoiBan', 'Users');

      Schema::table('Users',function(Blueprint $table){
        $table->renameColumn('ten','name');
        $table->renameColumn('sdt','email');
        $table->timestamp('email_verified_at')->nullable();
        $table->dropColumn('is_active');

      });

    }
}
