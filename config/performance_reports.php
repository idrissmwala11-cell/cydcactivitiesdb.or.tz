<?php

return [
    'modules' => [

        // MAIN PROGRAM MODULES
        'home_visitation' => [
            'model' => App\Models\HomeVisitation::class,
            'date_field' => 'created_at',
            'title' => 'Home Visitation',
        ],

        'talents_information' => [
            'model' => App\Models\TalentsInformation::class,
            'date_field' => 'created_at',
            'title' => 'Talents Information',
        ],

        'skills_information' => [
            'model' => App\Models\SkillsInformation::class,
            'date_field' => 'created_at',
            'title' => 'Skills Information',
        ],

        'parents_information' => [
            'model' => App\Models\ParentsInformation::class,
            'date_field' => 'created_at',
            'title' => 'Parents Information',
        ],

        'special_program' => [
            'model' => App\Models\SpecialProgram::class,
            'date_field' => 'created_at',
            'title' => 'Special Program',
        ],

        // ATTENDANCE MODULES
        'talent_attendance' => [
            'model' => App\Models\TalentAttendance::class,
            'date_field' => 'created_at',
            'title' => 'Talent Attendance',
        ],

        'skills_attendance' => [
            'model' => App\Models\SkillsAttendance::class,
            'date_field' => 'created_at',
            'title' => 'Skills Attendance',
        ],

        'curriculum_attendance' => [
            'model' => App\Models\CurriculumAttendance::class,
            'date_field' => 'created_at',
            'title' => 'Curriculum Attendance',
        ],

        // LEARNING MODULES
        'masomo_ya_mtaala' => [
            'model' => App\Models\MasomoYaMtaala::class,
            'date_field' => 'created_at',
            'title' => 'Masomo ya Mtaala',
        ],

        'masomo_ya_fani' => [
            'model' => App\Models\MasomoYaFani::class,
            'date_field' => 'created_at',
            'title' => 'Masomo ya Fani',
        ],

        // EXTRA PROGRAM MODULES
        'vocational_training' => [
            'model' => App\Models\VocationalTraining::class,
            'date_field' => 'created_at',
            'title' => 'Vocational Training',
        ],

        'saving_group' => [
            'model' => App\Models\SavingGroup::class,
            'date_field' => 'created_at',
            'title' => 'Saving Group',
        ],

        'center_leadership' => [
            'model' => App\Models\CenterLeadership::class,
            'date_field' => 'created_at',
            'title' => 'Center Leadership',
        ],

    ],
];
