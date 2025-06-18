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
            Schema::create('notulas', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->longText('description')->nullable();
                $table->foreignId('agenda_id')->constrained('agendas')->onDelete('cascade'); // Notula untuk agenda mana
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // User yang menulis notula
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
            Schema::dropIfExists('notulas');
        }
    };
    