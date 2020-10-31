<?php
// see comments of course.php
include('config.php');

$website = new Website($pdo);

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            if ($website->get_sites($_GET['id'])) {
                http_response_code(200);
                $result = $website->get_sites($_GET['id']);
            } else {
                http_response_code(404);
                $result = array('Message' => 'Failed to get website');
            }
        } else {
            if ($website->get_sites()) {
                http_response_code(200);
                $result = $website->get_sites();
            } else {
                http_response_code(404);
                $result = array('Message' => 'Failed to get website');
            }
        }
        break;
    
    case 'POST': // {"title" : "<h1>site</h1>", "url" : "http://axelhellberg.se", "info" : "The most Epic website"}
        $data = json_decode(file_get_contents('php://input'));

        $website->title = $data->title;
        $website->url = $data->url;
        $website->info = $data->info;

        if ($website->add_site()) {
            http_response_code(201);
            $result = array('Message' => 'Website added');
        } else {
            http_response_code(500);
            $result = array('Message' => 'Failed to add website');
        }
        break;

    case 'PUT': // {"id" : "1", "title" : "<h1>site 2</h1>", "url" : "http://axelhellberg.se", "info" : "The most Epic website"}
        $data = json_decode(file_get_contents('php://input'));

        $website->id = $data->id;
        $website->title = $data->title;
        $website->url = $data->url;
        $website->info = $data->info;

        if ($website->update_site()) {
            http_response_code(200);
            $result = array('Message' => 'Website updated');
        } else {
            http_response_code(500);
            $result = array('Message' => 'Failed to update website');
        }
        break;

    case 'DELETE':
        $id = file_get_contents('php://input');

        if ($id) {
            if ($website->delete_sites($id)) {
                http_response_code(200);
                $result = array('Message' => 'Website deleted');
            } else {
                http_response_code(404);
                $result = array('Message' => 'Failed to delete website');
            }
        } else {
            if ($website->delete_sites()) {
                http_response_code(200);
                $result = array('Message' => 'All websites deleted');
            } else {
                http_response_code(500);
                $result = array('Message' => 'Failed to delete all websites');
            }
        }
        break;
}

echo json_encode($result);
$pdo = null;
?>