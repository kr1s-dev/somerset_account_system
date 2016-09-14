<?php

use Illuminate\Database\Seeder;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $userTypeName = array('Administrator','Accountant','Cashier','Guest');
        $userTypeList = array();
        for ($i=0; $i < count($userTypeName) ; $i++) { 
            $userTypeList[] = array('type' => $userTypeName[$i],
                                    'created_at' => date('Y-m-d h:i:s'),
                                    'updated_at' => date('Y-m-d h:i:s'));
        }
        DB::table('user_type')->insert($userTypeList);
    }
}
