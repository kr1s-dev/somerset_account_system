<?php

namespace App\Http\Controllers\pdf;

use PDF;
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
    	switch ($category) {
    		case 'receipt':
    			return $this->generateReceiptPDF($recordId)->stream('receipt_'. date('m_d_y') .'.pdf');
    			break;
    		case 'invoice':
    		 	return $this->generateInvoicePDF($recordId)->stream('invoice_'. date('m_d_y') .'.pdf');
    		 	break;
    		case 'expense':
    		 	return $this->generateExpensePDF($recordId)->stream('expense_'. date('m_d_y').'.pdf');
    		 	break;
    		case 'income_statement_report':
    		 	return $this->generateIncomeStatementPDF($monthFilter,$yearFilter)->stream('income_statment_'. date('m_d_y').'.pdf');
    		 	break;
    		default:
    			# code...
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
		$monthArray = array('01'=>'January',
    						'02'=>'February',
    						'03'=>'March',
    						'04'=>'April',
    						'05'=>'May',
    						'06'=>'June',
    						'07'=>'July',
    						'08'=>'August',
    						'09'=>'September',
    						'10'=>'October',
    						'11'=>'November',
    						'12'=>'December');

		$incomeItemsList = array();
    	$expenseItemsList = array();
		if(empty($monthFilter)){
			//Get Income Statements
	    	$incStatementItemsList = HomeOwnerPendingPaymentModel::whereYear('created_at','=',date($yearFilter))->get();

			$expStatementItemsList = ExpenseItemModel::whereYear('created_at','=',date($yearFilter))->get();
		}else{
    		//Get Income Statements
	    	$incStatementItemsList = HomeOwnerPendingPaymentModel::whereYear('created_at','=',date($yearFilter))
						    												->whereMonth('created_at','=',date($monthFilter))
						    												->get();

			$expStatementItemsList = ExpenseItemModel::whereYear('created_at','=',date($yearFilter))
						    												->whereMonth('created_at','=',date($monthFilter))
						    												->get();
		}
		
		
		foreach ($incStatementItemsList as $incStatementItem) {
			if(array_key_exists($incStatementItem->accountTitle->account_sub_group_name,$incomeItemsList)){
				$incomeItemsList[$incStatementItem->accountTitle->account_sub_group_name] = ($incomeItemsList[$incStatementItem->accountTitle->account_sub_group_name] + $incStatementItem->amount);
			}else{
				$incomeItemsList[$incStatementItem->accountTitle->account_sub_group_name] = $incStatementItem->amount;
			}
		}


		foreach ($expStatementItemsList as $expStatementItem) {
			if(array_key_exists($expStatementItem->accountTitle->account_sub_group_name,$expenseItemsList)){
				$expenseItemsList[$expStatementItem->accountTitle->account_sub_group_name] = ($expenseItemsList[$expStatementItem->accountTitle->account_sub_group_name] + $expStatementItem->amount);
			}else{
				$expenseItemsList[$expStatementItem->accountTitle->account_sub_group_name] = $expStatementItem->amount;
			}
		}

		$incTotalSum = count($incomeItemsList)>0?array_sum($incomeItemsList):0;
		$expTotalSum = count($expenseItemsList)>0?array_sum($expenseItemsList):0;

		return PDF::loadView('pdf.income_statement_pdf',
								compact('incomeItemsList',
								'expenseItemsList',
								'incTotalSum',
								'expTotalSum',
								'monthArray',
								'yearFilter',
								'monthFilter'));
	}

}
