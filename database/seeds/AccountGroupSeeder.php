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
        //Set of default account groups in accounting
        $accountGoupNames = array('Current Assets',
                                    'Non-Current Assets',
                                    'Current Liabilities',
                                    'Non-Current Liabilities',
                                    'Revenues',
                                    'Expenses',
                                    'Owners Equity');
        $accountGroupsList = array();
    	for ($i=0; $i < count($accountGoupNames) ; $i++) { 
    	    $accountGroupsList[] = array('account_group_name' => $accountGoupNames[$i],
                                            'created_at' => date('Y-m-d h:i:sa'),
                                            'updated_at' => date('Y-m-d h:i:sa'));
    	}

    	DB::table('account_groups')->insert($accountGroupsList);
        
        //Insert default account titles needed by the systems
        $accountAssetTitles = array();
        $accountAssetTitles[] = array('account_group_id'=>7,
                                        'account_sub_group_name'=>'Somerset Capital',
                                        'created_at' => date('Y-m-d h:i:sa'),
                                        'updated_at' => date('Y-m-d h:i:sa'));
        DB::table('account_titles')->insert($accountAssetTitles);

    }
}
