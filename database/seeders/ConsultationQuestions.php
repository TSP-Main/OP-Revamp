<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConsultationQuestions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {  $consultationQuestions = config('constants.CONSULTATION_QUESTIONS');
        DB::table('consultation_questions')->insert($consultationQuestions);
    }
}
