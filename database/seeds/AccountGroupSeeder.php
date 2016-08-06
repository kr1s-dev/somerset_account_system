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
                                    'Fixed Assets',
                                    'Current Liabilities',
                                    'Fixed Liabilities',
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
        
        //insert account titles
        $accountAssetTitles = array();
        $accountAssetTitles[] = array('account_group_id'=>1,
                                        'account_sub_group_name'=>'Accounts Receivable',
                                        'default_value'=>0,
                                        'subject_to_vat'=>0,
                                        'vat_percent'=>0,
                                        'created_at' => date('Y-m-d h:i:sa'),
                                        'updated_at' => date('Y-m-d h:i:sa'));
        $accountAssetTitles[] = array('account_group_id'=>1,
                                        'account_sub_group_name'=>'Cash',
                                        'default_value'=>0,
                                        'subject_to_vat'=>0,
                                        'vat_percent'=>0,
                                        'created_at' => date('Y-m-d h:i:sa'),
                                        'updated_at' => date('Y-m-d h:i:sa'));
        $accountAssetTitles[] = array('account_group_id'=>5,
                                        'account_sub_group_name'=>'Association Dues',
                                        'default_value'=>448,
                                        'subject_to_vat'=>1,
                                        'vat_percent'=>12,
                                        'created_at' => date('Y-m-d h:i:sa'),
                                        'updated_at' => date('Y-m-d h:i:sa'));
        $accountAssetTitles[] = array('account_group_id'=>3,
                                        'account_sub_group_name'=>'Accounts Payable',
                                        'default_value'=>0,
                                        'subject_to_vat'=>0,
                                        'vat_percent'=>0,
                                        'created_at' => date('Y-m-d h:i:sa'),
                                        'updated_at' => date('Y-m-d h:i:sa'));
        $accountAssetTitles[] = array('account_group_id'=>7,
                                        'account_sub_group_name'=>'Somerset Capital',
                                        'default_value'=>0,
                                        'subject_to_vat'=>0,
                                        'vat_percent'=>0,
                                        'created_at' => date('Y-m-d h:i:sa'),
                                        'updated_at' => date('Y-m-d h:i:sa'));
        DB::table('account_titles')->insert($accountAssetTitles);

    }
}
