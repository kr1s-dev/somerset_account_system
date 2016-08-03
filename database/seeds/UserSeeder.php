<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $nUser = array('email'=>'admin_user@somerset.com',
        				'first_name'=>'I',
        				'middle_name'=> 'am',	
        				'last_name'=>'admin',
        				'mobile_number'=>'0929819201',
        				'password'=>bcrypt('testadmin12345'),
                        'secret_question_id'=>'1',
                        'secret_answer'=>'somer',
        				'user_type_id'=>1,
        				'created_at'=>date('m/d/y'),
        				'updated_at'=>date('m/d/y'),
                        'is_active'=>1,
                        'created_by'=>null,
                        'updated_by'=>null);
    	DB::table('users')->insert($nUser);
    }
}
