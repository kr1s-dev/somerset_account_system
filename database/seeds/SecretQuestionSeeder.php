<?php

use Illuminate\Database\Seeder;

class SecretQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $secretQuestionList = array('What was your childhood nickname?',
			                     'What is the name of your favorite childhood friend?',
			                     'What is your favorite team?',
			                     'What is your favorite movie?',
			                     'What was your favorite sport in high school?',
			                     'What was your favorite food as a child?',
			                     'What was the name of the hospital where you were born?',
			                     'What school did you attend for sixth grade?',
			                     'Who is your childhood sports hero?');
       	$secretQuestionListToInsert = array();
    	for ($i=0; $i < count($secretQuestionList) ; $i++) { 
    	    $secretQuestionListToInsert[] = array('secret_question' => $secretQuestionList[$i],
                                                    'created_at' => date('Y-m-d h:i:sa'),
                                                    'updated_at' => date('Y-m-d h:i:sa'));
    	}
        DB::table('secret_question')->insert($secretQuestionListToInsert);
    }
}
