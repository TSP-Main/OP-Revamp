<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PrescriptionMedGeneralQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $questions = config('constants.PRESCRIPTION_MED_GENERAL_QUESTIONS');
        DB::table('prescription_med_general_questions')->insert($questions);
    }
}
