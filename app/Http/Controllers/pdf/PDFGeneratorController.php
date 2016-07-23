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
    		case 'owner_equity_statement_report':
    		 	return $this->generateOwnerEquityStatementPDF($monthFilter,$yearFilter)->stream('income_statment_'. date('m_d_y').'.pdf');
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



}
