<?php

use Illuminate\Database\Seeder;

class HomeOwnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $nHomeOwnerList = array();
        $nHomeOwnerList[] = array('first_name' => 'I',
			                        'middle_name' => 'am',
			                        'last_name' => 'Guest',
			                        'member_occupation' => 'Developer',
			                        'residence_tel_no' => '2091092',
			                        'member_office_tel_no' => '1298291',
			                        'member_mobile_no' => '09280192812',
			                        'member_date_of_birth' => date('Y-m-d',strtotime('-2 year')),
			                        'member_address' => 'Ortigas Ave.',
			                        'member_email_address' => 'guest_user@somerset.co',
			                        'member_gender' => 'male',
                                    'block_lot_id'=>1,
                                    'created_at' => date('Y-m-d h:i:sa'),
                                    'updated_at' => date('Y-m-d h:i:sa'));
    	DB::table('home_owner_information')->insert($nHomeOwnerList);
    }
}
