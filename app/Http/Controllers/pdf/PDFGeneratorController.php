<?php

namespace App\Http\Controllers\pdf;

use PDF;
use Auth;
use App\ReceiptModel;
use App\ExpenseModel;
use App\HomeOwnerPendingPaymentModel;
use App\ExpenseItemModel;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UtilityHelper;

class PDFGeneratorController extends Controller
{
	use UtilityHelper;

    public function postGeneratePDF(Request $request){
    	$category = $request->input('category');
    	$recordId = $request->input('recordId');
    	$monthFilter = $request->input('month_filter');
    	$yearFilter = $request->input('year_filter');
        $type = $request->input('type');
    	switch ($category) {
    		case 'receipt':
    			return $this->generateReceiptPDF($recordId)->stream('receipt_'. date('m_d_y') .'.pdf');
    			break;
    		case 'invoice':
    		 	return $this->generateInvoicePDF($recordId)->stream('invoice_'. date('m_d_y') .'.pdf');
    		 	break;
    		case 'expense':
                if(Auth::user()->userType->type==='Administrator' || Auth::user()->userType->type==='Accountant')
    		 	    return $this->generateExpensePDF($recordId)->stream('expense_'. date('m_d_y').'.pdf');
                else
                    return view('errors.503');
    		 	break;
    		case 'income_statement_report':
                if(Auth::user()->userType->type==='Administrator' || Auth::user()->userType->type==='Accountant')
    		 	    return $this->generateIncomeStatementPDF($monthFilter,$yearFilter)->stream('income_statment_'. date('m_d_y').'.pdf');
    		 	else
                    return view('errors.503');
                break;
    		case 'owner_equity_statement_report':
                if(Auth::user()->userType->type==='Administrator' || Auth::user()->userType->type==='Accountant')
    		 	    return $this->generateOwnerEquityStatementPDF($monthFilter,$yearFilter)->stream('income_statment_'. date('m_d_y').'.pdf');
    		 	else
                    return view('errors.503');
                break;
            case 'balance_sheet_report':
                if(Auth::user()->userType->type==='Administrator' || Auth::user()->userType->type==='Accountant')
                    return $this->generateBalanceSheetPDF($monthFilter,$yearFilter)->stream('balance_sheet'. date('m_d_y').'.pdf');
                else
                    return view('errors.503');
                break;
            case 'subsidiary_ledger_report':
                if(Auth::user()->userType->type==='Administrator' || Auth::user()->userType->type==='Accountant')
                    return $this->generateSubsidiaryLedger($monthFilter,$yearFilter,$type)->setPaper('a4', 'landscape')->stream('subsidiary_ledger'. date('m_d_y').'.pdf');
                else
                    return view('errors.503');
                break;
    		default:
    			return view('errors.503');
    			break;
    	}
	}


	private function generateReceiptPDF($id){
		$receipt = $this->getHomeOwnerReceipt($id);
		$receiptNumber = $this->formatString($id);
		$invoiceNumber = $this->formatString($receipt->payment_id);
		return PDF::loadView('pdf.receipt_pdf',
								compact('receipt',
										'receiptNumber',
										'invoiceNumber'));
	}


	private function generateInvoicePDF($id){
		$invoice = $this->getHomeOwnerInvoice($id);
		$invoiceNumber = $this->formatString($id);
		return PDF::loadView('pdf.invoice_pdf',
								compact('invoice',
										'invoiceNumber'));
	}


	private function generateExpensePDF($id){
		$expense = $this->getExpense($id);
		$expenseNumber = $this->formatString($id);
		return PDF::loadView('pdf.expense_pdf',
								compact('expense',
										'expenseNumber'));
	}

	private function generateIncomeStatementPDF($monthFilter,$yearFilter){
		$yearFilter = $yearFilter==NULL?date('Y'):date($yearFilter);
        $monthArray = $this->monthsGenerator();

        $incStatementItemsList = $this->getJournalEntryRecordsWithFilter('5',$monthFilter,$yearFilter);
        $expStatementItemsList = $this->getJournalEntryRecordsWithFilter('6',$monthFilter,$yearFilter);

        $incomeItemsList = $this->getItemsAmountList($incStatementItemsList,'Income');
        $expenseItemsList = $this->getItemsAmountList($expStatementItemsList,'Expense');

        $incTotalSum = $this->getTotalSum($incomeItemsList);
        $expTotalSum = $this->getTotalSum($expenseItemsList);
    	

		return PDF::loadView('pdf.income_statement_pdf',
								compact('incomeItemsList',
								'expenseItemsList',
								'incTotalSum',
								'expTotalSum',
								'monthArray',
								'yearFilter',
								'monthFilter'));
	}

	private function generateOwnerEquityStatementPDF($monthFilter,$yearFilter){
		$yearFilter = $yearFilter==NULL?date('Y'):date($yearFilter);
        $monthArray = $this->monthsGenerator();

        $incStatementItemsList = $this->getJournalEntryRecordsWithFilter('5',$monthFilter,$yearFilter);
        $expStatementItemsList = $this->getJournalEntryRecordsWithFilter('6',$monthFilter,$yearFilter);

        $incomeItemsList = $this->getItemsAmountList($incStatementItemsList,'Income');
        $expenseItemsList = $this->getItemsAmountList($expStatementItemsList,'Expense');

        $incTotalSum = $this->getTotalSum($incomeItemsList);
        $expTotalSum = $this->getTotalSum($expenseItemsList);

        $totalProfit = ($incTotalSum  - $expTotalSum);

        $ownerEquityItemsList = $this->getJournalEntryRecordsWithFilter('7',$monthFilter,$yearFilter);

        $equityItemsList = $this->getItemsAmountList($ownerEquityItemsList,'Equity');

        $eqTotalSum = ($this->getTotalSum($equityItemsList)) + $totalProfit ;
    	//print_r($equityItemsList);
    	return PDF::loadView('pdf.owners_equity_statement_pdf',
    					compact('yearFilter',
    							'monthFilter',
    							'monthArray',
    							'eqTotalSum',
    							'equityItemsList',
    							'totalProfit'));
	}


    private function generateBalanceSheetPDF($monthFilter,$yearFilter){
        $yearFilter = $yearFilter==NULL?date('Y'):date($yearFilter);
        $monthArray = $this->monthsGenerator();
        $accountTitlesList =  $this->getAccountTitles(null);
        $accountTitleGroupList = $this->getAccountGroups(null);
        $fBalanceSheetItemsList = array();
        $totalAssets = 0;
        $totalEquity = 0;
        $totalLiability = 0;

        $incStatementItemsList = $this->getJournalEntryRecordsWithFilter('5',$monthFilter,$yearFilter);
        $expStatementItemsList = $this->getJournalEntryRecordsWithFilter('6',$monthFilter,$yearFilter);

        $incomeItemsList = $this->getItemsAmountList($incStatementItemsList,'Income');
        $expenseItemsList = $this->getItemsAmountList($expStatementItemsList,'Expense');

        $incTotalSum = $this->getTotalSum($incomeItemsList);
        $expTotalSum = $this->getTotalSum($expenseItemsList);

        $totalProfit = ($incTotalSum  - $expTotalSum);

        $aTitleItemsList = $this->getJournalEntryRecordsWithFilter(null,$monthFilter,$yearFilter);
        //print_r($aTitleItemsList);
        $eBalanceSheetItemsList = $this->getItemsAmountList($aTitleItemsList,null);


        foreach ($accountTitleGroupList as $accountTitleGroup) {
            if(!array_key_exists($accountTitleGroup->account_group_name,$fBalanceSheetItemsList)){
                $fBalanceSheetItemsList[$accountTitleGroup->account_group_name] = array();
            }
        }
        //print_r($eBalanceSheetItemsList);
        foreach ($accountTitlesList as $accountTitle) {
            

            if (array_key_exists($accountTitle->account_sub_group_name,$eBalanceSheetItemsList)) {
                if(array_key_exists($accountTitle->group->account_group_name,$fBalanceSheetItemsList)){
                    $tArray = $fBalanceSheetItemsList[$accountTitle->group->account_group_name];
                    $tArray[$accountTitle->account_sub_group_name] = strpos($accountTitle->account_sub_group_name, 'Capital') || $accountTitle->account_sub_group_name === 'Capital'? 
                                                                        ($eBalanceSheetItemsList[$accountTitle->account_sub_group_name] + $totalProfit) 
                                                                            : $eBalanceSheetItemsList[$accountTitle->account_sub_group_name];
                    $fBalanceSheetItemsList[$accountTitle->group->account_group_name] = $tArray;
                }
            }
        }

        foreach (array_keys($fBalanceSheetItemsList) as $key) {
            if(strpos($key, 'Assets')){
                $totalAssets+= ($this->getTotalSum($fBalanceSheetItemsList[$key]));
            }else if(strpos($key, 'Equity')){
                $totalEquity+= ($this->getTotalSum($fBalanceSheetItemsList[$key]));
            }else if(strpos($key, 'Liabilities')){
                $totalLiability+= ($this->getTotalSum($fBalanceSheetItemsList[$key]));
            }
        }


        return PDF::loadView('pdf.balance_sheet_pdf',
                                compact('yearFilter',
                                        'monthFilter',
                                        'monthArray',
                                        'fBalanceSheetItemsList',
                                        'totalAssets',
                                        'totalEquity',
                                        'totalLiability'));
    }


    public function generateSubsidiaryLedger($monthFilter,$yearFilter,$type){
        $yearFilter = $yearFilter==NULL?date('Y'):date($yearFilter);
        $monthArray = $this->monthsGenerator();
        $listOfItem = array(); //Key => Payee, Value => array(Items)
        $itemsList = array();
        $query;
        if($type=='homeowner'){
            $query = ReceiptModel::whereYear('created_at','=',$yearFilter);
        }else if($type=='vendor'){
            $query = ExpenseModel::whereYear('created_at','=',$yearFilter);
        }

        if(!empty($monthFilter))
            $query->whereMonth('created_at','=',$monthFilter);
        
        $itemsList = $query->get();
        
        foreach ($itemsList as $item) {
            $payeeName = $type=='homeowner' ? $item->invoice->homeOwner->first_name . ' ' . 
                                $item->invoice->homeOwner->middle_name . ' ' .
                                $item->invoice->homeOwner->last_name : $item->paid_to;

            
            foreach (($type=='homeowner'? $item->invoice->invoiceItems : $item->expenseItems)  as $val) {
                if(array_key_exists($payeeName, $listOfItem)){
                    $tItems = $listOfItem[$payeeName];
                    $tItems[] = $val;
                    $listOfItem[$payeeName] = $tItems;
                }else{
                    $listOfItem[$payeeName] = array($val);
                }
            }
        }

        return PDF::loadView('pdf.subsidiary_ledger_pdf',
                                compact('listOfItem',
                                        'monthArray',
                                        'yearFilter',
                                        'monthFilter',
                                        'type'));
    }



}
