<?php

namespace App\Http\Controllers\reports;

use Illuminate\Http\Request;
use App\HomeOwnerPendingPaymentModel;
use App\ExpenseItemModel;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UtilityHelper;

class ReportController extends Controller
{
    use UtilityHelper;

	public function postGenerateIncomeStatement(Request $request){
		$monthFilter = $request->input('month_filter');
		$yearFilter = $request->input('year_filter');
		return $this->generateIncomeStatement($monthFilter,$yearFilter);
	}

    public function getGenerateIncomeStatement(){
    	return $this->generateIncomeStatement(null,null);

    }

    public function postGenerateOwnersEquityStatement(Request $request){
		$monthFilter = $request->input('month_filter');
		$yearFilter = $request->input('year_filter');
		return $this->generateOwnersEquityStatement($monthFilter,$yearFilter);
	}

    public function getGenerateOwnersEquityStatement(){
    	return $this->generateOwnersEquityStatement(null,null);

    }


    public function generateIncomeStatement($monthFilter,$yearFilter){
    	$yearFilter = $yearFilter==NULL?date('Y'):date($yearFilter);
    	$monthArray = $this->monthsGenerator();

    	$incStatementItemsList = $this->getRecordsWithFilter($this->getJournalEntryRecordsWithYearFilter('journal_entry','5'),
    													$monthFilter,
    													$yearFilter);
    	$expStatementItemsList = $this->getRecordsWithFilter($this->getJournalEntryRecordsWithYearFilter('journal_entry','6'),
    													$monthFilter,
    													$yearFilter);

    	$incomeItemsList = $this->getItemsAmountList($incStatementItemsList,'Income');
    	$expenseItemsList = $this->getItemsAmountList($expStatementItemsList,'Expense');

    	$incTotalSum = $this->getTotalSum($incomeItemsList);
    	$expTotalSum = $this->getTotalSum($expenseItemsList);

		return view('reports.income_statement',
						compact('incomeItemsList',
								'expenseItemsList',
								'incTotalSum',
								'expTotalSum',
								'monthArray',
								'yearFilter',
								'monthFilter'));
    }

    public function generateOwnersEquityStatement($monthFilter,$yearFilter){
    	$yearFilter = $yearFilter==NULL?date('Y'):date($yearFilter);
    	$monthArray = $this->monthsGenerator();

    	$incStatementItemsList = $this->getRecordsWithFilter($this->getJournalEntryRecordsWithYearFilter('journal_entry','5'),
    													$monthFilter,
    													$yearFilter);
    	$expStatementItemsList = $this->getRecordsWithFilter($this->getJournalEntryRecordsWithYearFilter('journal_entry','6'),
    													$monthFilter,
    													$yearFilter);

    	$incomeItemsList = $this->getItemsAmountList($incStatementItemsList,'Income');
    	$expenseItemsList = $this->getItemsAmountList($expStatementItemsList,'Expense');

    	$incTotalSum = $this->getTotalSum($incomeItemsList);
    	$expTotalSum = $this->getTotalSum($expenseItemsList);

    	$totalProfit = ($incTotalSum  - $expTotalSum);

    	$ownerEquityItemsList = $this->getRecordsWithFilter($this->getJournalEntryRecordsWithYearFilter('journal_entry','7'),
    													$monthFilter,
    													$yearFilter);

    	$equityItemsList = $this->getItemsAmountList($ownerEquityItemsList,'Equity');

    	$eqTotalSum = ($this->getTotalSum($equityItemsList)) + $totalProfit ;

    	//print_r($equityItemsList);
    	return view('reports.statement_of_owners_equity',
    					compact('yearFilter',
    							'monthFilter',
    							'monthArray',
    							'eqTotalSum',
    							'equityItemsList',
    							'totalProfit'));

    }
}
