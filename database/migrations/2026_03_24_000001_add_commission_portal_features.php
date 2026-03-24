<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::table('commissioners', function (Blueprint $table) {
            $table->string('username')->nullable()->unique()->after('name');
            $table->string('password')->nullable()->after('username');
            $table->unsignedTinyInteger('manual_requests_used')->default(0)->after('is_banned');
        });

        Schema::table('commissions', function (Blueprint $table) {
            $table->unsignedInteger('image_count')->default(1)->after('commission_type');
            $table->boolean('is_multi_image')->default(false)->after('image_count');
            $table->boolean('awaiting_approval')->default(false)->after('status');
            $table->longText('client_feedback')->nullable()->after('comments');
        });

        Schema::create('commission_update_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('commission_id');
            $table->string('title');
            $table->text('image_path');
            $table->unsignedInteger('sort')->default(0);
            $table->timestamps();

            $table->foreign('commission_id')->references('id')->on('commissions')->onDelete('cascade');
        });

        Schema::create('commission_update_image_characters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('commission_update_image_id');
            $table->string('name');
            $table->text('reference_url')->nullable();
            $table->timestamps();

            $table->foreign('commission_update_image_id', 'commission_update_image_characters_update_fk')
                ->references('id')->on('commission_update_images')->onDelete('cascade');
        });

        if (Schema::hasTable('commission_classes') && Schema::hasTable('site_settings')) {
            $classes = DB::table('commission_classes')->get();
            foreach ($classes as $class) {
                $keys = [
                    $class->slug.'_comms_mode'   => 'open',
                    $class->slug.'_open_text'    => '',
                    $class->slug.'_closed_text'  => '',
                    $class->slug.'_manual_text'  => '',
                ];
                foreach ($keys as $key => $value) {
                    if (!DB::table('site_settings')->where('key', $key)->exists()) {
                        DB::table('site_settings')->insert([
                            'key'         => $key,
                            'value'       => $value,
                            'description' => 'Auto-generated commission portal setting.',
                        ]);
                    }
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('commission_update_image_characters');
        Schema::dropIfExists('commission_update_images');

        Schema::table('commissions', function (Blueprint $table) {
            $table->dropColumn(['image_count', 'is_multi_image', 'awaiting_approval', 'client_feedback']);
        });

        Schema::table('commissioners', function (Blueprint $table) {
            $table->dropUnique(['username']);
            $table->dropColumn(['username', 'password', 'manual_requests_used']);
        });
    }
};
