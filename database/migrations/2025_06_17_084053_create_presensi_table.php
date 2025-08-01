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
            Schema::create('presensi', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Guru yang presensi
                $table->foreignId('agenda_id')->constrained('agendas')->onDelete('cascade'); // Agenda terkait
                $table->enum('status', ['hadir', 'tidak_hadir', 'izin']);
                $table->text('keterangan')->nullable();
                $table->timestamps();
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down()
        {
            Schema::dropIfExists('presensi');
        }
    };
    