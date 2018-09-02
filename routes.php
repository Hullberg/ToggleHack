<?php
function call($controller, $action) {
	// Get the name of the controller
	require_once('controllers/' . $controller . '_controller.php');
	require_once('models/item.php');
        require_once('models/itemcomment.php');

	// New controller
	switch($controller) {
		case 'pages':
			$controller = new PagesController();
			break;
		case 'cart':
			$controller = new CartController();
			break;
		case 'users':
			$controller = new UsersController();
			break;
		default:
			$controller = new PagesController();
		
	}

	// Call action in controller
	$controller->{ $action }();
}

// Add the controllers with their actions
$controllers = array('pages' => array('home', 'error', 'search', 'register', 'itempage', 'addcomment', 'toggle_sql', 'toggle_xss', 'toggle_cookies', 'reset_site'),
                    'cart' => array('add', 'remove', 'clearCart', 'checkout'),
                    'users' => array('register', 'login', 'logout'));

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