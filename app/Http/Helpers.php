<?php

function getDashboardCounts($user_id){

	$user = App\Models\User::where('id', $user_id)->first();

	//$application_approve_sum = $user->application()->where('status','CONFIRMED')->sum('total_fare');
	$application_approve_count = $user->application()->where('status','CONFIRMED')->count();
	$application_decline_count = $user->application()->where('status', 'DECLINED')->count();

	return array(
		"application_approve_count" => $application_decline_count,
		"application_decline_count" => $application_decline_count
	);
}

?>