<?php
function call($controller, $action) {
	// Get the name of the controller
	require_once('controllers/' . $controller . '_controller.php');

	// New instance
	switch($controller) {
		case 'pages':
			$controller = new PagesController();
		// Can add more controllers below	
		break;
	}

	// Call action in controller
	$controller->{ $action }();
}

// Add the controllers with their actions
$controllers = array('pages' => ['home', 'error']);

// Get the controller->action pair
if (array_key_exists($controller, $controllers)) {
	if (in_array($action, $controllers[$controller])) {
		call($controller, $action);
	} else {
		call('pages', 'error');
	}
} else {
	call('pages', 'error');
}
?>