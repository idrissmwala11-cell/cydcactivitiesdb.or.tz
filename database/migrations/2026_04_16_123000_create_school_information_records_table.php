<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('school_information_records', function (Blueprint $table) {
            $table->id();
            $table->string('education_level');
            $table->json('form_data');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->index(['education_level', 'user_id']);
        });

        if (! Schema::hasTable('submissions')) {
            return;
        }

        $map = [
            'school_primary' => 'primary',
            'school_secondary' => 'secondary',
            'school_a_level' => 'a-level',
            'school_university' => 'university',
            'school_college' => 'college',
            'school_vocational_training' => 'vocational-training',
            'school_others' => 'others',
        ];

        DB::table('submissions')
            ->whereIn('section_type', array_keys($map))
            ->orderBy('id')
            ->chunkById(100, function ($rows) use ($map) {
                foreach ($rows as $row) {
                    $data = json_decode($row->form_data ?? '[]', true);

                    DB::table('school_information_records')->insert([
                        'education_level' => $map[$row->section_type] ?? 'others',
                        'form_data' => json_encode(is_array($data) ? $data : []),
                        'user_id' => $row->user_id,
                        'created_at' => $row->created_at ? Carbon::parse($row->created_at) : now(),
                        'updated_at' => $row->updated_at ? Carbon::parse($row->updated_at) : now(),
                    ]);
                }
            });
    }

    public function down(): void
    {
        Schema::dropIfExists('school_information_records');
    }
};
