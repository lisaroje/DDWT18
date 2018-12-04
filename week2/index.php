<?php
/**
 * Controller
 * User: reinardvandalen
 * Date: 05-11-18
 * Time: 15:25
 */

include 'model.php';

/* Connect to DB */
$db = connect_db('localhost', 'ddwt18_week2', 'ddwt18','ddwt18');

/* Getting number of series on each page */
$nbr_series = count_series($db);

/* Getting number of users on each page */
$nbr_users = count_users($db);

/* Setting right column of each page */
$right_column = use_template('cards');

/* Getting serie and user id */
$serie_id = $_GET['serie_id'];
$serie_info = get_serieinfo($db,$serie_id);
$user_id = get_user_id();

/* Navigation Array */
$template = Array(
    1 => Array(
        'name' => 'Home',
        'url' => '/DDWT18/week2/'
    ),
    2 => Array(
        'name' => 'Overview',
        'url' => '/DDWT18/week2/overview/'
    ),
    3 => Array(
        'name' => 'My Account',
        'url' => '/DDWT18/week2/myaccount/'
    ),
    4 => Array(
        'name' => 'Register',
        'url' => '/DDWT18/week2/register/'
    ));

/* Landing page */
if (new_route('/DDWT18/week2/', 'get')) {

    /* Page info */
    $page_title = 'Home';
    $breadcrumbs = get_breadcrumbs([
        'DDWT18' => na('/DDWT18/', False),
        'Week 2' => na('/DDWT18/week2/', False),
        'Home' => na('/DDWT18/week2/', True)
    ]);
    $navigation = get_navigation($template, 1);

    /* Page content */
    $page_subtitle = 'The online platform to list your favorite series';
    $page_content = 'On Series Overview you can list your favorite series. You can see the favorite series of all Series Overview users. By sharing your favorite series, you can get inspired by others and explore new series.';

    /* Choose Template */
    include use_template('main');
}

/* Overview page */
elseif (new_route('/DDWT18/week2/overview/', 'get')) {

    /* Page info */
    $page_title = 'Overview';
    $breadcrumbs = get_breadcrumbs([
        'DDWT18' => na('/DDWT18/', False),
        'Week 2' => na('/DDWT18/week2/', False),
        'Overview' => na('/DDWT18/week2/overview', True)
    ]);
    $navigation = get_navigation($template, 2);

    /* Page content */
    $page_subtitle = 'The overview of all series';
    $page_content = 'Here you find all series listed on Series Overview.';
    $left_content = get_serie_table(get_series($db));

    /* Get error msg from POST remove route */
    if ( isset($_GET['error_msg'], $_GET['serie_id'])){
        $error_msg = get_error($_GET['error_msg']);
        $serie_id = get_serieinfo($db, $_GET['serie_id']);
    }

    /* Choose Template */
    include use_template('main');
}

/* Single Serie */
elseif (new_route('/DDWT18/week2/serie/', 'get')) {
    /* Check if logged in user is the same as editor */
    $display_buttons = False;
    if ($_SESSION['user_id'] == $serie_info['user']){
        $display_buttons = True;
    }
    /* Get username */
    $user_name = get_user_name($db, $user_id);


    /* Page info */
    $page_title = $serie_info['name'];
    $breadcrumbs = get_breadcrumbs([
        'DDWT18' => na('/DDWT18/', False),
        'Week 2' => na('/DDWT18/week2/', False),
        'Overview' => na('/DDWT18/week2/overview/', False),
        $serie_info['name'] => na('/DDWT18/week2/serie/?serie_id='.$serie_id, True)
    ]);
    $navigation = get_navigation($template, 2);

    /* Page content */
    $page_subtitle = sprintf("Information about %s", $serie_info['name']);
    $page_content = $serie_info['abstract'];
    $nbr_seasons = $serie_info['seasons'];
    $creators = $serie_info['creator'];
    $added_by = $user_name;

    /* Choose Template */
    include use_template('serie');
}

/* Add serie GET */
elseif (new_route('/DDWT18/week2/add/', 'get')) {
    /* Check if logged in */
    if (!check_login()) {
        redirect('/DDWT18/week2/login/');
    }
    /* Page info */
    $page_title = 'Add Series';
    $breadcrumbs = get_breadcrumbs([
        'DDWT18' => na('/DDWT18/', False),
        'Week 2' => na('/DDWT18/week2/', False),
        'Add Series' => na('/DDWT18/week2/new/', True)
    ]);
    $navigation = get_navigation($template, 3);
    /* Page content */
    $page_subtitle = 'Add your favorite series';
    $page_content = 'Fill in the details of you favorite series.';
    $submit_btn = "Add Series";
    $form_action = '/DDWT18/week2/add/';
    /* Get error msg from POST route */
    if ( isset($_GET['error_msg']) ) {
        $error_msg = get_error($_GET['error_msg']);
    }
    /* Choose Template */
    include use_template('new');


}

/* Add serie POST */
elseif (new_route('/DDWT18/week2/add/', 'post')){
    /* Check if logged in */
    if (!check_login()) {
        redirect('/DDWT18/week2/login/');
    }
    /* Add serie to database */
    $feedback = add_serie($db, $_POST);
    /* Redirect to serie GET rout */
    redirect(sprintf('/DDWT18/week2/add/?error_msg=%s', json_encode($feedback)));

}

/* Edit serie GET */
elseif (new_route('/DDWT18/week2/edit/', 'get')) {
    /* Check if logged in */
    if (!check_login()) {
        redirect('/DDWT18/week2/login/');
    }
    /* Get serie info from db */
    $serie_info = get_serieinfo($db, $serie_id);

    /* Page info */
    $page_title = 'Edit Series';
    $breadcrumbs = get_breadcrumbs([
        'DDWT18' => na('/DDWT18/', False),
        'Week 2' => na('/DDWT18/week2/', False),
        sprintf("Edit Series %s", $serie_info['name']) => na('/DDWT18/week2/new/', True)
    ]);
    $navigation = get_navigation($template, 0);
    /* Page content */
    $page_subtitle = sprintf("Edit %s", $serie_info['name']);
    $page_content = 'Edit the series below.';
    $submit_btn = "Edit Series";
    $form_action = '/DDWT18/week2/edit/';

    /* Get error msg from POST route */

    if ( isset($_GET['error_msg'], $_GET['serie_id'])){
        $error_msg = get_error($_GET['error_msg']);
        $serie_id = get_serieinfo($db, $_GET['serie_id']);
    }

    /* Choose Template */
    include use_template('new');
}

/* Edit serie POST */
elseif (new_route('/DDWT18/week2/edit/', 'post')) {
    /* Check if logged in */
    if (!check_login()) {
        redirect('/DDWT18/week2/login/');
    }
    /* Update serie in database */
    $feedback = update_serie($db, $_POST);
    redirect(sprintf('/DDWT18/week2/get/?error_msg=%s'));

}
/* Remove serie */
elseif (new_route('/DDWT18/week2/remove/', 'post')) {
    /* Check if logged in */
    if (!check_login()) {
        redirect('/DDWT18/week2/login/');
    }
    /* Remove serie in database */
    $feedback = remove_serie($db, $_POST);
    redirect(sprintf('/DDWT18/week2/overview/?error_msg=%s', json_encode($feedback)));
}

/* My Account page */
elseif (new_route('/DDWT18/week2/myaccount/', 'get')) {
    /* Check if logged in */
    if (!check_login()) {
        redirect('/DDWT18/week2/login/');
    }

    /* Page info */
    $page_title = 'My Account';
    $breadcrumbs = get_breadcrumbs([
        'DDWT18' => na('/DDWT18/', False),
        'Week 2' => na('/DDWT18/week2/', False),
        'Overview' => na('/DDWT18/week2/myaccount', True)
    ]);
    $navigation = get_navigation($template, 4);

    /* Page content */
    $page_subtitle = 'Overview of your account';
    $page_content = 'See here an overview of your account';

    /* Get error msg from POST route */
    if (isset($_GET['error_msg'])) {
        $error_msg = get_error($_GET['error_msg']);
    }

    /* Choose Template */
    include use_template('account');

}

/* Getting register page */
elseif (new_route('/DDWT18/week2/register/', 'get')) {

    /* Page info */
    $page_title = 'Register Account';
    $breadcrumbs = get_breadcrumbs([
        'DDWT18' => na('/DDWT18/', False),
        'Week 2' => na('/DDWT18/week2/', False),
        'Overview' => na('/DDWT18/week2/register', True)
    ]);
    $navigation = get_navigation($template, 5);

    /* Page content */
    $page_subtitle = 'Register your account';
    $page_content = 'Register your account below';

    /* Get error msg from POST route */
    if (isset($_GET['error_msg'])) {
        $error_msg = get_error($_GET['error_msg']);
    }
    /* Choose template */
    include use_template('register');
}
elseif (new_route('/DDWT18/week2/register/', 'post')) {
    /* Register post */
    $feedback = register_user($db, $_POST);
    redirect(sprintf('/DDWT18/week2/register/?error_msg=%s', json_encode($feedback)));
}

/* Getting register page */
elseif (new_route('/DDWT18/week2/register/', 'get')) {
    /* Check if logged in */
    if (check_login()) {
        redirect('/DDWT18/week2/myacccount/');
    }
    /* Page info */
    $page_title = 'Login Page';
    $breadcrumbs = get_breadcrumbs([
        'DDWT18' => na('/DDWT18/', False),
        'Week 2' => na('/DDWT18/week2/', False),
        'Overview' => na('/DDWT18/week2/login/', True)
    ]);
    $navigation = get_navigation($template, 0);

    /* Page content */
    $page_subtitle = 'Enter your username and password to login';

    /* Get error msg from POST route */
    if (isset($_GET['error_msg'])) {
        $error_msg = get_error($_GET['error_msg']);
    }
    /* Choose template */
    include use_template('login');

}
elseif (new_route('/DDWT18/week2/login/', 'post')) {
    /* Post login */
    $feedback = login_user($db, $_POST);
    redirect(sprintf('/DDWT18/week2/login/?error_msg=%s', json_encode($feedback)));
}

elseif (new_route('/DDWT18/week2/logout', 'get')){
    /* Get logout page */
    $feedback = logout_user($db);
    redirect(sprintf('/DDWT/week2/?error_msg=%s', json_encode($feedback)));
}

else {
    http_response_code(404);
}

