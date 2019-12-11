<?php

function getDashboardCounts($user_id){

	$user = App\Models\User::where('id', $user_id)->first();

	//$application_approve_sum = $user->application()->where('status','CONFIRMED')->sum('total_fare');
	$application_approve_count = $user->application()->where('status','CONFIRMED')->count();
	$application_pending_count = $user->application()->where('status','PENDING')->count();
	$application_decline_count = $user->application()->where('status', 'DECLINED')->count();

	return array(
		"application_approve_count" => $application_decline_count,
		"application_pending_count" => $application_pending_count,
		"application_decline_count" => $application_decline_count
	);
}

function getCategories() {
	
	$motor_types = \App\Models\MotorType::get();

	return $motor_types;
}

function getMonthlyPayment($user_id,$application_id) {
	$application = \App\Models\Application::with('product','user')->where('id',$application_id)->where('user_id',$user_id)->first();
	$payment = \App\Models\Payment::where('application_id',$application_id)->where('user_id',$user_id)->first();

	$monthly_payment = ( $application->product->price - ( $application->down_payment ) ) / $application->payment_length;

	return $monthly_payment;
}

function getTotalBalance($user_id,$application_id) {
	$application = \App\Models\Application::with('product','user')->where('id',$application_id)->where('user_id',$user_id)->first();
	$payment = \App\Models\Payment::where('application_id',$application_id)->where('user_id',$user_id)->first();

	$balance = ( $application->product->price - ( $application->down_payment + $payment->amount ) );

	return $balance;
}

?>