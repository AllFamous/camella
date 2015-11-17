<?php /* Template Name: Camella Generate Pdf Page */ ?>
<?php

	// generate pdf ajax
	$pdf = new FPDF('P', 'mm', array(216, 356));

	// Column Headings
	$computeLoanType = $_GET['computeLoanType'];
	$computeDownpayment = $_GET['computeDownpayment'];
	$computeTerms = $_GET['computeTerms'];
	$computeFullName = $_GET['computeFullName'];
	$computeEmailAddress = $_GET['computeEmailAddress'];
	$modelName = $_GET['modelName'];
	$modelLowPrice = $_GET['modelLowPrice'];
	$projectLocation = $_GET['projectLocation'];

	$pdf->AddPage();

	// header image
	$logo = get_template_directory_uri().'/img/common/logo-camella-green.png';
	$pdf->Image($logo, 10, 11, 40, 0, 'PNG');

	// document title
	$pdf->SetFont('Arial', '', 16);
	$pdf->SetTextColor(179, 212, 73);
	$pdf->Cell(0, 13, 'CAMELLA SAMPLE COMPUTATION', 0, 1, 'R');

	$pdf->Ln();

	$pdf->SetFont('Arial', '', 8);
	$pdf->SetTextColor(0, 0, 0);
	$pdf->Cell(0, 5, 'QUOTATION FOR : '.$computeFullName.' ('.$computeEmailAddress.')', 0, 1, 'L');
	$pdf->Cell(0, 5, 'DATE GENERATED : '.date('Y/m/d'), 0, 1, 'L');
	$pdf->Cell(0, 5, 'MODEL NAME : '.$modelName.'', 0, 1, 'L');
	$pdf->Cell(0, 5, 'PROJECT LOCATION : '.$projectLocation.'', 0, 1, 'L');
	$pdf->Cell(0, 5, 'TOTAL CONTRACT PRICE : '.convertToPrice($modelLowPrice).'', 0, 1, 'L');
	$pdf->Cell(0, 5, 'LOAN TYPE : '.getLoanType($computeLoanType).'', 0, 1, 'L');
	$pdf->Cell(0, 5, 'DOWNPAYMENT : '.getDownPayment($computeDownpayment).'', 0, 1, 'L');
	$pdf->Cell(0, 5, 'LOAN TERMS : '.getTerms($computeTerms).'', 0, 1, 'L');

	// compute monthly
	$ratePerPeriod = 0;
	if ($computeLoanType == 1){
		$ratePerPeriod = 0.14 / 12;
	} else {
		$ratePerPeriod = 0.08 / 12;
	}
	$numberOfPayments = $computeTerms * 12;
	$rateDownpayment = $computeDownpayment / 100;
	$amountDownpayment = $modelLowPrice * $rateDownpayment;
	$amountLoan = $modelLowPrice - $amountDownpayment;
	$monthsPayable = 14;
	$amountReservationFee = getReservationFee($modelLowPrice);
	$amountDownpaymentMonthly = ($amountDownpayment - $amountReservationFee) / $monthsPayable;

	$monthlyPayments = computeComputationPMT($ratePerPeriod, $numberOfPayments, $amountLoan, 0, 1);

	$header = array('Total Contract Price', 'Downpayment ('.getDownPayment($computeDownpayment).')', 'Reservation Fee', 'Months Payable');
	for($i = 1; $i <= $monthsPayable; $i++){
		array_push($header, 'Month '.$i);
	}
	array_push($header, 'Loandable Amount');
	array_push($header, 'Monthly Ammortization - '.getTerms($computeTerms));

	$content = array(convertToPrice($modelLowPrice), convertToPrice($amountDownpayment), convertToPrice($amountReservationFee), $monthsPayable);
	for($i = 1; $i <= $monthsPayable; $i++){
		array_push($content, convertToPrice($amountDownpaymentMonthly));
	}
	array_push($content, convertToPrice($amountLoan));
	array_push($content, convertToPrice($monthlyPayments));

	$pdf->Ln();

	foreach($header AS $key => $row){
		$pdf->SetFont('Arial', '', 8);
        $pdf->Cell(80, 7, $row, 1);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(60, 7, $content[$key], 1, 0, 'R');
        $pdf->Ln();
    }

    $pdf->Ln();
    $pdf->SetFont('Arial', 'I', 8);
	$pdf->SetTextColor(168, 168, 168);
    $disclaimerText = 'DISCLAIMER: All details, figures, rates, computations, etc. appearing herein are still subject to change without prior notice. Please consult one of our Camella Sales Agents. This document is for estimation purposes only.';
	$pdf->MultiCell(180, 4, $disclaimerText, 0, 'L', false);


	//Let user download file
	$pdf->Output('Camella-'.$projectLocation.'-'.$modelName.'-'.date('Y/m/d').'.pdf', 'D');

?>