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
        Schema::create('menus', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('title');
            $table->string('group_name', 100)->nullable();
            $table->string('route_name')->nullable();
            $table->string('menu_url')->nullable();
            $table->string('menu_icon')->nullable();
            $table->unsignedSmallInteger('menu_order')->default(1);
            $table->unsignedSmallInteger('parent_menu_id')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('visible_to_all_user')->default(true);

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('roles', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('title', 150);
            $table->string('slug', 150)->unique()->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('remarks')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('slug')->unique()->nullable();
            $table->string('controller_method')->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('remarks')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('role_user', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignId('user_id');
            $table->unsignedSmallInteger('role_id');
            $table->boolean('is_primary')->default(false);
            $table->boolean('is_active')->default(true);
            $table->dateTime('released_at')->nullable();

            // $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('role_id')->references('id')->on('roles');
            $table->timestamps();
        });

        Schema::create('permission_role', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('permission_id');
            $table->unsignedSmallInteger('role_id');

            $table->foreign('permission_id')->references('id')->on('permissions');
            $table->foreign('role_id')->references('id')->on('roles');

            $table->timestamps();
        });

        Schema::create('menu_role', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedSmallInteger('role_id');
            $table->unsignedSmallInteger('menu_id');

            $table->foreign('role_id')->references('id')->on('roles');
            $table->foreign('menu_id')->references('id')->on('menus');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_user');
        Schema::dropIfExists('permission_role');
        Schema::dropIfExists('menu_role');

        Schema::dropIfExists('menus');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('permissions');
    }
};
