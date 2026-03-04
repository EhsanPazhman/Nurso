<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('password');
            $table->boolean('is_active')->default(true);

            /*
|--------------------------------------------------------------------------
| Self-referencing foreign keys
|--------------------------------------------------------------------------
| We define the columns first, then apply explicit foreign constraints
| to avoid naming conflicts and MySQL auto-generated constraint issues.
*/

            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->foreign('created_by', 'users_created_by_foreign')
                ->references('id')
                ->on('users')
                ->nullOnDelete();

            $table->foreign('updated_by', 'users_updated_by_foreign')
                ->references('id')
                ->on('users')
                ->nullOnDelete();

            /*
|--------------------------------------------------------------------------
| Department relation
|--------------------------------------------------------------------------
*/

            $table->foreignId('department_id')
                ->nullable()
                ->constrained('departments')
                ->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
