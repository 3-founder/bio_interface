<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('demosi_promosi_pangkat', function (Blueprint $table) {
            $table->string('kd_entitas_baru', 15)->nullable(true)->change();
            $table->string('kd_jabatan_lama', 15)->nullable(true)->change();
            $table->string('kd_jabatan_baru', 15)->nullable(true)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('demosi_promosi_pangkat', function (Blueprint $table) {
            $table->string('kd_entitas_baru', 15)->nullable(false)->change();
            $table->string('kd_jabatan_lama', 15)->nullable(false)->change();
            $table->string('kd_jabatan_baru', 15)->nullable(false)->change();
        });
    }
};
