<?php

function getDashboardCounts($user_id){

	$user = App\Models\User::where('id', $user_id)->first();

	//$application_approve_sum = $user->application()->where('status','CONFIRMED')->sum('total_fare');
	$application_approve_count = $user->application()->where('status','APPROVED')->count();
	$application_pending_count = $user->application()->where('status','PENDING')->count();
	$application_decline_count = $user->application()->where('status', 'DECLINED')->count();

	$loans = \App\Models\Application::with('product','user')->where('user_id',$user_id)->where('status','APPROVED')->get();
	$payment = \App\Models\Payment::where('user_id',$user_id)->sum('amount');

	$total_loan = 0;
	$total_down_payment = 0;
	foreach($loans as $loan) {
		$total_loan += $loan->product->price;
	}
	$balance = $total_loan - $payment;

	return array(
		"application_approve_count" => $application_decline_count,
		"application_pending_count" => $application_pending_count,
		"application_decline_count" => $application_decline_count,
		"balance" => $balance
	);
}

function getCategories() {
	
	$motor_types = \App\Models\MotorType::get();

	return $motor_types;
}

function getMonthlyPayment($user_id,$application_id) {
	$application = \App\Models\Application::with('product','user')->where('id',$application_id)->where('user_id',$user_id)->whereIn('status',['APPROVED','PENDING'])->first();
	$payment = \App\Models\Payment::where('application_id',$application_id)->where('user_id',$user_id)->first();

	$monthly_payment = ( $application->product->price - ( $application->down_payment ) ) / $application->payment_length;

	return $monthly_payment;
}

function getTotalBalance($user_id,$application_id) {
	$application = \App\Models\Application::with('product','user')->where('id',$application_id)->where('user_id',$user_id)->where('status','APPROVED')->first();
	$payment = \App\Models\Payment::where('application_id',$application_id)->where('user_id',$user_id)->sum('amount');

	$balance = $application->product->price - $payment;

	return $balance;
}

function getTotalDue($user_id) {
	
	$dt = \Carbon\Carbon::now();

	$loans = \App\Models\Application::with('product','user')->where('user_id',$user_id)->where('status','APPROVED')->get();

	$months_to_pay = 0;

	$monthly_payment = 0;

	foreach($loans as $loan) {

		$past = \Carbon\Carbon::parse($loan->last_payment_date);
	
		$final = $past->format('Y-m-d');
	
		//$months_to_pay = $past->diffInMonths($dt);

		if($past->diffInMonths($dt) > 0) {
			$months_to_pay++;
		}

		$monthly_payment = ( $loan->product->price - ( $loan->down_payment ) ) / $loan->payment_length;

	}
	
	$total = 0;

    if($months_to_pay > 0)  {
		$total = $monthly_payment * $months_to_pay;
	}

	return array(
		"months_to_pay" => $months_to_pay,
		"total_due" => $total
	);
}

function getAdminDashboardCounts() {
	
	$dt = \Carbon\Carbon::now();

	$loans = \App\Models\Application::with('product','user')->where('status','APPROVED')->get();

	$months_to_pay = 0;

	$monthly_payment = 0;

	foreach($loans as $loan) {

		$past = \Carbon\Carbon::parse($loan->last_payment_date);
	
		$final = $past->format('Y-m-d');
	
		//$months_to_pay = $past->diffInMonths($dt);

		if($past->diffInMonths($dt) > 0) {
			$months_to_pay++;
		}

		$monthly_payment = ( $loan->product->price - ( $loan->down_payment ) ) / $loan->payment_length;

	}
	
	$total = 0;

    if($months_to_pay > 0)  {
		$total = $monthly_payment * $months_to_pay;
	}

	return array(
		"months_to_pay" => $months_to_pay,
		"total_due" => $total
	);
}


?>