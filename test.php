<?php
	include('config.php');
	include('utils.php');

	// Get params
	$debug = isset($_GET['d']) ? true : false;

	$result = call_url(
		'mc.spectrumbranch.com:8123/apoc_minecraft/parsedLogs.json',
		array(
			"apikey" => $config['apikey']
		)
	);

	if ($debug) {
		echo "<pre>";
		echo json_encode($result);
		die();
	}

	$display = array();
	foreach ($result as $logfile) {
		foreach ($logfile as $key => $type) {
			if (is_array($type)) {
				foreach ($type as $entry) {

					switch ($key) {
						// case 'login':
						// case 'logout':
						// 	if (!isset($display[$entry->user]))
						// 		$display[$entry->user] = array();
						// 	if (!isset($display[$entry->user][$key]))
						// 		$display[$entry->user][$key] = 1;
						// 	else
						// 		$display[$entry->user][$key] += 1;
						// 	break;
						case 'kill':
							if (!isset($display[$entry->target]))
								$display[$entry->target] = array();

							$entry->actor = preg_replace('/ using \[.+\]/', '', $entry->actor);

							if (!isset($display[$entry->actor]['kill']))
								$display[$entry->actor]['kill'] = 0;
							if (!isset($display[$entry->target]['death']))
								$display[$entry->target]['death'] = 0;

							$display[$entry->actor]['kill'] += 1;
							$display[$entry->target]['death'] += 1;

							break;
						case 'death':
							if (!isset($display[$entry->target]))
								$display[$entry->target] = array();
							if (!isset($display[$entry->target][$key]))
								$display[$entry->target][$key] = 1;
							else
								$display[$entry->target][$key] += 1;
							break;
						default:
							break;
					}
				}
			}
		}
	}
	ksort($display);

	echo "<pre>";
	echo json_encode($display);

?>