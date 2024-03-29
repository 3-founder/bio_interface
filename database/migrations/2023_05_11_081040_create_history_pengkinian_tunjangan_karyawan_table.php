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
        Schema::create('history_pengkinian_tunjangan_karyawan', function (Blueprint $table) {
            $table->id();
            $table->string('nip', 25);
            $table->unsignedBigInteger('id_tunjangan');
            $table->integer('nominal');
            $table->timestamps();

            $table->foreign('id_tunjangan')
                ->references('id')
                ->on('mst_tunjangan')
                ->onUpdate('cascade');

            $table->foreign('nip')
                ->references('nip')
                ->on('mst_karyawan')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('history_pengkinian_tunjangan_karyawan');
    }
};
