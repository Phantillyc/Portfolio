<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        if (Schema::hasTable('commissioners')) {
            Schema::table('commissioners', function (Blueprint $table) {
                if (!Schema::hasColumn('commissioners', 'username')) {
                    $table->string('username')->nullable()->unique()->after('id');
                }
                if (!Schema::hasColumn('commissioners', 'password')) {
                    $table->string('password')->nullable()->after('username');
                }
                if (!Schema::hasColumn('commissioners', 'remember_token')) {
                    $table->rememberToken();
                }
            });
        }

        if (Schema::hasTable('commissions')) {
            Schema::table('commissions', function (Blueprint $table) {
                if (!Schema::hasColumn('commissions', 'public_token')) {
                    $table->uuid('public_token')->nullable()->unique()->after('id');
                }
                if (!Schema::hasColumn('commissions', 'lifecycle_state')) {
                    $table->string('lifecycle_state', 32)->default('active')->index()->after('status');
                }
                if (!Schema::hasColumn('commissions', 'admin_phase')) {
                    $table->string('admin_phase', 32)->nullable()->index()->after('lifecycle_state');
                }
                if (!Schema::hasColumn('commissions', 'requested_commission_type')) {
                    $table->string('requested_commission_type')->nullable()->after('commission_type');
                }
                if (!Schema::hasColumn('commissions', 'submitted_at')) {
                    $table->timestamp('submitted_at')->nullable()->after('created_at');
                }
                if (!Schema::hasColumn('commissions', 'manually_closed_at')) {
                    $table->timestamp('manually_closed_at')->nullable()->after('submitted_at');
                }
                if (!Schema::hasColumn('commissions', 'vision_request_text')) {
                    $table->longText('vision_request_text')->nullable()->after('comments');
                }
                if (!Schema::hasColumn('commissions', 'general_notes')) {
                    $table->longText('general_notes')->nullable()->after('vision_request_text');
                }
                if (!Schema::hasColumn('commissions', 'is_draft')) {
                    $table->boolean('is_draft')->default(false)->index()->after('lifecycle_state');
                }
            });
        }

        if (!Schema::hasTable('commission_availability_settings')) {
            Schema::create('commission_availability_settings', function (Blueprint $table) {
                $table->id();
                $table->string('state', 16)->default('open')->index();
                $table->longText('open_richtext')->nullable();
                $table->longText('closed_richtext')->nullable();
                $table->longText('manual_richtext')->nullable();
                $table->unsignedBigInteger('updated_by_admin_id')->nullable()->index();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('commission_manual_permissions')) {
            Schema::create('commission_manual_permissions', function (Blueprint $table) {
                $table->id();
                $table->unsignedInteger('commissioner_id')->index();
                $table->unsignedBigInteger('granted_by_admin_id')->nullable()->index();
                $table->boolean('is_consumed')->default(false)->index();
                $table->timestamp('consumed_at')->nullable();
                $table->timestamps();

                $table->foreign('commissioner_id')->references('id')->on('commissioners')->onDelete('cascade');
            });
        }

        if (!Schema::hasTable('homepage_blocks')) {
            Schema::create('homepage_blocks', function (Blueprint $table) {
                $table->id();
                $table->string('machine_key')->nullable()->unique();
                $table->string('title')->nullable();
                $table->longText('content_richtext')->nullable();
                $table->integer('sort_order')->default(0)->index();
                $table->boolean('is_enabled')->default(true)->index();
                $table->unsignedBigInteger('updated_by_admin_id')->nullable()->index();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('characters')) {
            Schema::create('characters', function (Blueprint $table) {
                $table->id();
                $table->string('slug')->unique();
                $table->string('name');
                $table->string('gender')->nullable();
                $table->string('age')->nullable();
                $table->string('breed')->nullable();
                $table->longText('bio_richtext')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('character_designer_credits')) {
            Schema::create('character_designer_credits', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('character_id')->index();
                $table->string('credit_name');
                $table->text('credit_url')->nullable();
                $table->integer('sort_order')->default(0);
                $table->timestamps();

                $table->foreign('character_id')->references('id')->on('characters')->onDelete('cascade');
            });
        }

        if (!Schema::hasTable('character_family_rows')) {
            Schema::create('character_family_rows', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('character_id')->index();
                $table->string('group_label')->nullable();
                $table->integer('row_order')->default(0);
                $table->string('relative_name')->nullable();
                $table->text('relative_name_url')->nullable();
                $table->string('relative_breed')->nullable();
                $table->text('relative_breed_url')->nullable();
                $table->text('notes')->nullable();
                $table->timestamps();

                $table->foreign('character_id')->references('id')->on('characters')->onDelete('cascade');
            });
        }

        if (!Schema::hasTable('gallery_items')) {
            Schema::create('gallery_items', function (Blueprint $table) {
                $table->id();
                $table->string('slug')->unique();
                $table->string('title');
                $table->longText('description_richtext')->nullable();
                $table->string('source_type', 32)->default('portfolio')->index();
                $table->unsignedInteger('source_commission_id')->nullable()->index();
                $table->unsignedBigInteger('source_commission_image_id')->nullable()->index();
                $table->boolean('is_published')->default(true)->index();
                $table->timestamp('published_at')->nullable()->index();
                $table->unsignedBigInteger('cover_image_id')->nullable();
                $table->unsignedBigInteger('created_by_admin_id')->nullable()->index();
                $table->timestamps();

                $table->foreign('source_commission_id')->references('id')->on('commissions')->nullOnDelete();
            });
        }

        if (!Schema::hasTable('gallery_images')) {
            Schema::create('gallery_images', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('gallery_item_id')->index();
                $table->text('image_path');
                $table->text('caption')->nullable();
                $table->integer('sort_order')->default(0)->index();
                $table->boolean('is_final_from_commission')->default(false)->index();
                $table->timestamps();

                $table->foreign('gallery_item_id')->references('id')->on('gallery_items')->onDelete('cascade');
            });

            Schema::table('gallery_items', function (Blueprint $table) {
                $table->foreign('cover_image_id')->references('id')->on('gallery_images')->nullOnDelete();
            });
        }

        if (!Schema::hasTable('gallery_item_characters')) {
            Schema::create('gallery_item_characters', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('gallery_item_id')->index();
                $table->unsignedBigInteger('character_id')->index();
                $table->timestamps();

                $table->unique(['gallery_item_id', 'character_id']);
                $table->foreign('gallery_item_id')->references('id')->on('gallery_items')->onDelete('cascade');
                $table->foreign('character_id')->references('id')->on('characters')->onDelete('cascade');
            });
        }

        if (!Schema::hasTable('commission_request_characters')) {
            Schema::create('commission_request_characters', function (Blueprint $table) {
                $table->id();
                $table->unsignedInteger('commission_id')->index();
                $table->string('character_name');
                $table->text('reference_url')->nullable();
                $table->text('notes')->nullable();
                $table->integer('sort_order')->default(0);
                $table->timestamps();

                $table->foreign('commission_id')->references('id')->on('commissions')->onDelete('cascade');
            });
        }

        if (!Schema::hasTable('commission_images')) {
            Schema::create('commission_images', function (Blueprint $table) {
                $table->id();
                $table->unsignedInteger('commission_id')->index();
                $table->unsignedInteger('image_index');
                $table->string('title')->nullable();
                $table->string('state', 32)->default('not_started')->index();
                $table->timestamp('marked_complete_at')->nullable();
                $table->timestamp('approved_at')->nullable();
                $table->timestamps();

                $table->unique(['commission_id', 'image_index']);
                $table->foreign('commission_id')->references('id')->on('commissions')->onDelete('cascade');
            });
        }

        if (!Schema::hasTable('commission_image_assignments')) {
            Schema::create('commission_image_assignments', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('commission_image_id')->index();
                $table->unsignedBigInteger('commission_request_character_id')->index();
                $table->timestamps();

                $table->unique(['commission_image_id', 'commission_request_character_id'], 'commission_image_assignment_unique');
                $table->foreign('commission_image_id')->references('id')->on('commission_images')->onDelete('cascade');
                $table->foreign('commission_request_character_id')->references('id')->on('commission_request_characters')->onDelete('cascade');
            });
        }

        if (!Schema::hasTable('commission_image_progress_entries')) {
            Schema::create('commission_image_progress_entries', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('commission_image_id')->index();
                $table->string('stage', 32)->default('other')->index();
                $table->string('title');
                $table->text('image_path');
                $table->unsignedBigInteger('uploaded_by_admin_id')->nullable()->index();
                $table->timestamps();

                $table->foreign('commission_image_id')->references('id')->on('commission_images')->onDelete('cascade');
            });
        }

        if (!Schema::hasTable('commission_comments')) {
            Schema::create('commission_comments', function (Blueprint $table) {
                $table->id();
                $table->unsignedInteger('commission_id')->index();
                $table->string('author_type', 16)->index();
                $table->unsignedBigInteger('author_admin_id')->nullable()->index();
                $table->unsignedInteger('author_commissioner_id')->nullable()->index();
                $table->string('comment_type', 32)->default('general')->index();
                $table->longText('body');
                $table->timestamps();

                $table->foreign('commission_id')->references('id')->on('commissions')->onDelete('cascade');
                $table->foreign('author_commissioner_id')->references('id')->on('commissioners')->nullOnDelete();
            });
        }

        if (!Schema::hasTable('commission_gallery_publications')) {
            Schema::create('commission_gallery_publications', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('commission_image_id')->unique();
                $table->unsignedBigInteger('gallery_item_id')->unique();
                $table->unsignedBigInteger('created_by_admin_id')->nullable()->index();
                $table->timestamp('published_at')->nullable()->index();
                $table->timestamps();

                $table->foreign('commission_image_id')->references('id')->on('commission_images')->onDelete('cascade');
                $table->foreign('gallery_item_id')->references('id')->on('gallery_items')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('commission_gallery_publications');
        Schema::dropIfExists('commission_comments');
        Schema::dropIfExists('commission_image_progress_entries');
        Schema::dropIfExists('commission_image_assignments');
        Schema::dropIfExists('commission_images');
        Schema::dropIfExists('commission_request_characters');
        Schema::dropIfExists('gallery_item_characters');

        if (Schema::hasTable('gallery_items')) {
            Schema::table('gallery_items', function (Blueprint $table) {
                if (Schema::hasColumn('gallery_items', 'cover_image_id')) {
                    $table->dropForeign(['cover_image_id']);
                }
            });
        }

        Schema::dropIfExists('gallery_images');
        Schema::dropIfExists('gallery_items');
        Schema::dropIfExists('character_family_rows');
        Schema::dropIfExists('character_designer_credits');
        Schema::dropIfExists('characters');
        Schema::dropIfExists('homepage_blocks');
        Schema::dropIfExists('commission_manual_permissions');
        Schema::dropIfExists('commission_availability_settings');

        if (Schema::hasTable('commissions')) {
            Schema::table('commissions', function (Blueprint $table) {
                $drops = [];
                foreach (['public_token', 'lifecycle_state', 'admin_phase', 'requested_commission_type', 'submitted_at', 'manually_closed_at', 'vision_request_text', 'general_notes', 'is_draft'] as $column) {
                    if (Schema::hasColumn('commissions', $column)) {
                        $drops[] = $column;
                    }
                }
                if (count($drops)) {
                    $table->dropColumn($drops);
                }
            });
        }

        if (Schema::hasTable('commissioners')) {
            Schema::table('commissioners', function (Blueprint $table) {
                if (Schema::hasColumn('commissioners', 'remember_token')) {
                    $table->dropRememberToken();
                }
            });
        }
    }
};
