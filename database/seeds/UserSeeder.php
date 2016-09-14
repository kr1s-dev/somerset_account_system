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
        $nUserList = array();
        $nUserList[] = array('email'=>'admin_user@somerset.com',
            				'first_name'=>'I',
            				'middle_name'=> 'am',	
            				'last_name'=>'admin',
            				'mobile_number'=>'0929819201',
            				'password'=>bcrypt('testadmin12345'),
                            'secret_question_id'=>'1',
                            'secret_answer'=>'somer',
            				'user_type_id'=>1,
            				'created_at'=>date('Y-m-d h:i:sa'),
            				'updated_at'=>date('Y-m-d h:i:sa'),
                            'is_active'=>1,
                            'home_owner_id'=>null,
                            'created_at' => date('Y-m-d h:i:sa'),
                            'updated_at' => date('Y-m-d h:i:sa'));

        $nUserList[] = array('email'=>'admin_user@somerset1.com',
                            'first_name'=>'I',
                            'middle_name'=> 'am',   
                            'last_name'=>'admin',
                            'mobile_number'=>'0929819201',
                            'password'=>bcrypt('testadmin11111'),
                            'secret_question_id'=>'1',
                            'secret_answer'=>'somer',
                            'user_type_id'=>1,
                            'created_at'=>date('Y-m-d h:i:sa'),
                            'updated_at'=>date('Y-m-d h:i:sa'),
                            'is_active'=>1,
                            'home_owner_id'=>null,
                            'created_at' => date('Y-m-d h:i:sa'),
                            'updated_at' => date('Y-m-d h:i:sa'));

        $nUserList[] = array('email'=>'admin_user@somerset2.com',
                            'first_name'=>'I',
                            'middle_name'=> 'am',   
                            'last_name'=>'admin',
                            'mobile_number'=>'0929819201',
                            'password'=>bcrypt('testadmin22222'),
                            'secret_question_id'=>'1',
                            'secret_answer'=>'somer',
                            'user_type_id'=>1,
                            'created_at'=>date('Y-m-d h:i:sa'),
                            'updated_at'=>date('Y-m-d h:i:sa'),
                            'is_active'=>1,
                            'home_owner_id'=>null,
                            'created_at' => date('Y-m-d h:i:sa'),
                            'updated_at' => date('Y-m-d h:i:sa'));

        $nUserList[] = array('email'=>'accountant_user@somerset.com',
                                'first_name'=>'I',
                                'middle_name'=> 'am',   
                                'last_name'=>'Accountant',
                                'mobile_number'=>'0929819201',
                                'password'=>bcrypt('testadmin12345'),
                                'secret_question_id'=>'1',
                                'secret_answer'=>'somer',
                                'user_type_id'=>2,
                                'created_at'=>date('Y-m-d h:i:s'),
                                'updated_at'=>date('Y-m-d h:i:s'),
                                'home_owner_id'=>null,
                                'is_active'=>1);

        $nUserList[] = array('email'=>'cashier_user@somerset.com',
                                'first_name'=>'I',
                                'middle_name'=> 'am',   
                                'last_name'=>'Cashier',
                                'mobile_number'=>'0929819201',
                                'password'=>bcrypt('testadmin12345'),
                                'secret_question_id'=>'1',
                                'secret_answer'=>'somer',
                                'user_type_id'=>3,
                                'home_owner_id'=>null,
                                'created_at'=>date('Y-m-d h:i:s'),
                                'updated_at'=>date('Y-m-d h:i:s'),
                                'is_active'=>1);

        $nUserList[] = array('email'=>'guest_user@somerset.com',
                                'first_name'=>'I',
                                'middle_name'=> 'am',   
                                'last_name'=>'Guest',
                                'mobile_number'=>'0929819201',
                                'password'=>bcrypt('testadmin12345'),
                                'secret_question_id'=>'1',
                                'secret_answer'=>'somer',
                                'user_type_id'=>4,
                                'home_owner_id'=>1,
                                'created_at'=>date('Y-m-d h:i:s'),
                                'updated_at'=>date('Y-m-d h:i:s'),
                                'is_active'=>1);
    	DB::table('users')->insert($nUserList);
    }
}
