<?php
// see comments of course.php
include('config.php');

$job = new Job($pdo);

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            if ($job->get_jobs($_GET['id'])) {
                http_response_code(200);
                $result = $job->get_jobs($_GET['id']);
            } else {
                http_response_code(404);
                $result = array('Message' => 'Failed to get job');
            }
        } else {
            if ($job->get_jobs()) {
                http_response_code(200);
                $result = $job->get_jobs();
            } else {
                http_response_code(404);
                $result = array('Message' => 'Failed to get job');
            }
        }
        break;
    
    case 'POST': // {"workplace":"<h1>Testplace</h1>","title":"worker","start_date":"2020-01-01","end_date":"2030-01-01"}
        $data = json_decode(file_get_contents('php://input'));

        $job->workplace = $data->workplace;
        $job->title = $data->title;
        $job->start_date = $data->start_date;
        $job->end_date = $data->end_date;

        if ($job->add_job()) {
            http_response_code(201);
            $result = array('Message' => 'job added');
        } else {
            http_response_code(500);
            $result = array('Message' => 'Failed to add job');
        }
        break;

    case 'PUT': // {"id":"1","workplace":"<h1>Testplace 2</h1>","title":"workerman","start_date":"2020-01-02","end_date":"2030-02-22"}
        $data = json_decode(file_get_contents('php://input'));

        $job->id = $data->id;
        $job->workplace = $data->workplace;
        $job->title = $data->title;
        $job->start_date = $data->start_date;
        $job->end_date = $data->end_date;

        if ($job->update_job()) {
            http_response_code(200);
            $result = array('Message' => 'job updated');
        } else {
            http_response_code(500);
            $result = array('Message' => 'Failed to update job');
        }
        break;

    case 'DELETE':
        $id = file_get_contents('php://input');

        if ($id) {
            if ($job->delete_jobs($id)) {
                http_response_code(200);
                $result = array('Message' => 'job deleted');
            } else {
                http_response_code(404);
                $result = array('Message' => 'Failed to delete job');
            }
        } else {
            if ($job->delete_jobs()) {
                http_response_code(200);
                $result = array('Message' => 'All jobs deleted');
            } else {
                http_response_code(500);
                $result = array('Message' => 'Failed to delete all jobs');
            }
        }
        break;
}

echo json_encode($result);
$pdo = null;
?>