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
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('country')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('activation_token')->nullable();
            $table->boolean('is_activated')->default(true);
            $table->string('password');
            $table->string('image')->default('user.png');
            $table->string('role')->default('student');
            $table->string('status')->default('pending');
            $table->rememberToken();
            $table->timestamps();
        });

        // Add indexes to role and is_activated columns
        Schema::table('users', function (Blueprint $table) {
            $table->index(['role', 'is_activated']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the indexes
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['role', 'is_activated']);
        });

        Schema::dropIfExists('users');
    }
};

