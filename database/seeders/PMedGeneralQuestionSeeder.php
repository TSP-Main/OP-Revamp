<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\PMedGeneralQuestion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PMedGeneralQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $questions = config('constants.P_MED_GENERAL_QUESTIONS');
        DB::table('p_med_general_questions')->insert($questions);
    }
}
