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
            Schema::create('agendas', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->text('description')->nullable();
                $table->date('meeting_date')->nullable(); // Kolom tambahan dari ERD 
                $table->time('meeting_time')->nullable(); // Kolom tambahan dari ERD 
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // User yang membuat agenda
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
            Schema::dropIfExists('agendas');
        }
    };
    