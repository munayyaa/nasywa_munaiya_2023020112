<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('siswas', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        $table->string('nis')->nullable()->unique();
        $table->string('nama_lengkap');
        $table->string('tempat_lahir')->nullable();
        $table->date('tanggal_lahir')->nullable();
        $table->text('alamat')->nullable();
        $table->timestamps();
    });
}
    
    public function down(): void
    {
        Schema::dropIfExists('siswas');
    }
};