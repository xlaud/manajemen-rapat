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
            Schema::create('dokumentasi', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->text('description')->nullable();
                $table->string('file_path')->nullable(); // Path ke file dokumentasi
                $table->foreignId('agenda_id')->nullable()->constrained('agendas')->onDelete('set null'); // Opsional: terkait agenda
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // User yang mengunggah
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
            Schema::dropIfExists('dokumentasi');
        }
    };
    