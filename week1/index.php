<?php
/**
 * Controller
 * User: reinardvandalen
 * Date: 05-11-18
 * Time: 15:25
 */

include 'model.php';

/* Connecting connect_db function to the Controller */
$db = connect_db('localhost', 'ddwt18_week1', 'ddwt18', 'ddwt18');
/* Call for series count so it can be shown on each page */
$series_count = count_series($db);

/* Landing page */
if (new_route('/DDWT18/week1/', 'get')) {
    /* Page info */
    $page_title = 'Home';
    $breadcrumbs = get_breadcrumbs([
        'DDWT18' => na('/DDWT18/', False),
        'Week 1' => na('/DDWT18/week1/', False),
        'Home' => na('/DDWT18/week1/', True)
    ]);
    $navigation = get_navigation([
        'Home' => na('/DDWT18/week1/', True),
        'Overview' => na('/DDWT18/week1/overview/', False),
        'Add Series' => na('/DDWT18/week1/add/', False)
    ]);

    /* Page content */
    $right_column = use_template('cards');
    $page_subtitle = 'The online platform to list your favorite series';
    $page_content = 'On Series Overview you can list your favorite series. You can see the favorite series of all Series Overview users. By sharing your favorite series, you can get inspired by others and explore new series.';

    /* Choose Template */
    include use_template('main');
}

/* Overview page */
elseif (new_route('/DDWT18/week1/overview/', 'get')) {
    /* Page info */
    $page_title = 'Overview';
    $breadcrumbs = get_breadcrumbs([
        'DDWT18' => na('/DDWT18/', False),
        'Week 1' => na('/DDWT18/week1/', False),
        'Overview' => na('/DDWT18/week1/overview', True)
    ]);
    $navigation = get_navigation([
        'Home' => na('/DDWT18/week1/', False),
        'Overview' => na('/DDWT18/week1/overview', True),
        'Add Series' => na('/DDWT18/week1/add/', False)
    ]);

    /* Get series from database and build table */
    $series = get_series($db);
    $series = get_series_table($series);

    /* Page content */
    $right_column = use_template('cards');
    $page_subtitle = 'The overview of all series';
    $page_content = 'Here you find all series listed on Series Overview.';
    $left_content = $series;

    /* Choose Template */
    include use_template('main');
}

/* Single Serie */
elseif (new_route('/DDWT18/week1/serie/', 'get')) {
    /* Get series info from db */
    $serie_id = $_GET(['serie_id']);
    $series_info = get_series_info($db, $serie_id);

    /* Page info */
    $page_title = $series_info['name'];
    $breadcrumbs = get_breadcrumbs([
        'DDWT18' => na('/DDWT18/', False),
        'Week 1' => na('/DDWT18/week1/', False),
        'Overview' => na('/DDWT18/week1/overview/', False),
        $series_info['name'] => na('/DDWT18/week1/serie/', True)
    ]);
    $navigation = get_navigation([
        'Home' => na('/DDWT18/week1/', False),
        'Overview' => na('/DDWT18/week1/overview', True),
        'Add Series' => na('/DDWT18/week1/add/', False)
    ]);

    /* Page content */
    $right_column = use_template('cards');
    $page_subtitle = sprintf("Information about %s", $series_info['name']);
    $page_content = $series_info['abstract'];

    /* Choose Template */
    include use_template('serie');
}

/* Add serie GET */
elseif (new_route('/DDWT18/week1/add/', 'get')) {
    /* Page info */
    $page_title = 'Add Series';
    $breadcrumbs = get_breadcrumbs([
        'DDWT18' => na('/DDWT18/', False),
        'Week 1' => na('/DDWT18/week1/', False),
        'Add Series' => na('/DDWT18/week1/new/', True)
    ]);
    $navigation = get_navigation([
        'Home' => na('/DDWT18/week1/', False),
        'Overview' => na('/DDWT18/week1/overview', False),
        'Add Series' => na('/DDWT18/week1/add/', True)
    ]);

    /* Page content */
    $right_column = use_template('cards');
    $page_subtitle = 'Add your favorite series';
    $page_content = 'Fill in the details of you favorite series.';
    $submit_btn = "Add Series";
    $form_action = '/DDWT18/week1/add/';

    /* Choose Template */
    include use_template('new');
}

/* Add serie POST */
elseif (new_route('/DDWT18/week1/add/', 'post')) {
    /* Adding series to database and getting error message */
    $series_info = $_POST(['series_info']);
    $error_msg = get_error(add_series($db, $series_info));

    /* Page Info */
    $page_title = 'Add Series';
    $breadcrumbs = get_breadcrumbs([
        'DDWT18' => na('/DDWT18/', False),
        'Week 1' => na('/DDWT18/week1/', False),
        'Add Series' => na('/DDWT18/week1/add/', True)
    ]);
    $navigation = get_navigation([
        'Home' => na('/DDWT18/week1/', False),
        'Overview' => na('/DDWT18/week1/overview', False),
        'Add Series' => na('/DDWT18/week1/add/', True)
    ]);

    /* Page content */
    $right_column = use_template('cards');
    $page_subtitle = 'Add your favorite series';
    $page_content = 'Fill in the details of you favorite series.';
    $submit_btn = "Add Series";
    $form_action = '/DDWT18/week1/add/';

    include use_template('new');
}

/* Edit serie GET */
elseif (new_route('/DDWT18/week1/edit/', 'get')) {
    /* Get serie info from db */
    $serie_id = $_GET(['serie_id']);
    $series_info = get_series_info($db, $serie_id);
    $submit_btn = "Edit Series";
    $form_action = '/DDWT18/week1/edit';


    /* Page info */
    $page_title = 'Edit Series';
    $breadcrumbs = get_breadcrumbs([
        'DDWT18' => na('/DDWT18/', False),
        'Week 1' => na('/DDWT18/week1/', False),
        sprintf("Edit Series %s", $series_info['name']) => na('/DDWT18/week1/new/', True)
    ]);
    $navigation = get_navigation([
        'Home' => na('/DDWT18/week1/', False),
        'Overview' => na('/DDWT18/week1/overview', False),
        'Add Series' => na('/DDWT18/week1/add/', False)
    ]);

    /* Page content */
    $right_column = use_template('cards');
    $page_subtitle = sprintf("Edit %s", $series_info['name']);
    $page_content = 'Edit the series below.';

    /* Choose Template */
    include use_template('new');
}

/* Edit serie POST */
elseif (new_route('/DDWT18/week1/edit/', 'post')) {
    /* Get serie info from db */
    $serie_id = $_POST['serie_id'];
    $series_info = get_series_info($db, $serie_id);
    $error_msg = get_error(add_series($db, $series_info));
    include use_template('new');

    /* Page info */
    $page_title = $series_info['name'];
    $breadcrumbs = get_breadcrumbs([
        'DDWT18' => na('/DDWT18/', False),
        'Week 1' => na('/DDWT18/week1/', False),
        'Overview' => na('/DDWT18/week1/overview/', False),
        $series_info['name'] => na('/DDWT18/week1/serie/', True)
    ]);
    $navigation = get_navigation([
        'Home' => na('/DDWT18/week1/', False),
        'Overview' => na('/DDWT18/week1/overview', False),
        'Add Series' => na('/DDWT18/week1/add/', False)
    ]);

    /* Page content */
    $right_column = use_template('cards');
    $page_subtitle = sprintf("Information about %s", $series_info['name']);
    $page_content = $series_info['abstract'];

    /* Choose Template */
    include use_template('serie');
}

/* Remove serie */
elseif (new_route('/DDWT18/week1/remove/', 'post')) {
    /* Remove serie in database */
    $serie_id = $_POST(['serie_id']);
    $series_info = get_series_info($db, $serie_id);
    $feedback = remove_series($db, $serie_id, $series_info);
    $error_msg = get_error($feedback);

    /* Page info */
    $page_title = 'Overview';
    $breadcrumbs = get_breadcrumbs([
        'DDWT18' => na('/DDWT18/', False),
        'Week 1' => na('/DDWT18/week1/', False),
        'Overview' => na('/DDWT18/week1/overview', True)
    ]);
    $navigation = get_navigation([
        'Home' => na('/DDWT18/week1/', False),
        'Overview' => na('/DDWT18/week1/overview', True),
        'Add Series' => na('/DDWT18/week1/add/', False)
    ]);
    /* Get series from database and build table */
    $series = get_series($db);
    $series = get_series_table($series);

    /* Page content */
    $right_column = use_template('cards');
    $page_subtitle = 'The overview of all series';
    $page_content = 'Here you find all series listed on Series Overview.';
    $left_content = $series;

    /* Choose Template */
    include use_template('main');
}

else {
    http_response_code(404);
}