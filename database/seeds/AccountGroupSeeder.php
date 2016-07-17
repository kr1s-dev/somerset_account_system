<?php

use Illuminate\Database\Seeder;

class AccountGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $accountGoupNames = array('Current Assets',
                                    'Non Current Assets',
                                    'Current Liabilities',
                                    'Non Current Liabilities',
                                    'Revenues',
                                    'Expenses',
                                    'Owners Equity');
        $accountGroupsList = array();
    	for ($i=0; $i < count($accountGoupNames) ; $i++) { 
    	    $accountGroupsList[] = array('account_group_name' => $accountGoupNames[$i]);
    	}
    	DB::table('account_groups')->insert($accountGroupsList);
        
        //insert account titles
        $accountAssetTitles = array();
        $accountAssetTitles[] = array('account_group_id'=>1,
                                        'account_sub_group_name'=>'Account Receivables',
                                        'created_at' => date('m/d/y'),
                                        'updated_at' => date('m/d/y'));
        $accountAssetTitles[] = array('account_group_id'=>1,
                                        'account_sub_group_name'=>'Cash',
                                        'created_at' => date('m/d/y'),
                                        'updated_at' => date('m/d/y'));
        $accountAssetTitles[] = array('account_group_id'=>5,
                                        'account_sub_group_name'=>'Association Dues',
                                        'created_at' => date('m/d/y'),
                                        'updated_at' => date('m/d/y'));
        DB::table('account_titles')->insert($accountAssetTitles);

    }
}
