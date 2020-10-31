<?php
include('config.php'); // include database connection variable, headers, request method variable, class autoload, and error reporting.

$course = new Course($pdo); // new class instance with database connection

switch ($method) { // switch for HTTP-requests
    case 'GET': // case for GET request
        if (isset($_GET['id'])) { // get specific item if id variable set
            if ($course->get_courses($_GET['id'])) {
                http_response_code(200); // OK
                $result = $course->get_courses($_GET['id']); // store result in variable
            } else {
                http_response_code(404);
                $result = array('Message' => 'Failed to get course');
            }
        } else { // if no variable set, get all items
            if ($course->get_courses()) {
                http_response_code(200);
                $result = $course->get_courses(); // store result in variable
            } else {
                http_response_code(404);
                $result = array('Message' => 'Failed to get course');
            }
        }
        break;
    
    case 'POST': // case for POST request {"uni":"<h1>harvard</h1>","title":"rocket science","startdate":"2002-01-23","enddate":"2030-01-28"}
        $data = json_decode(file_get_contents('php://input')); // store posted data from php data stream

        // set class properties from posted data
        $course->uni = $data->uni;
        $course->title = $data->title;
        $course->start_date = $data->start_date;
        $course->end_date = $data->end_date;

        // use class method to add item
        if ($course->add_course()) {
            http_response_code(201);
            $result = array('Message' => 'Course added');
        } else {
            http_response_code(500);
            $result = array('Message' => 'Failed to add course');
        }
        break;

    case 'PUT': // case for PUT request
        $data = json_decode(file_get_contents('php://input'));

        $course->id = $data->id;
        $course->uni = $data->uni;
        $course->title = $data->title;
        $course->start_date = $data->start_date;
        $course->end_date = $data->end_date;

        if ($course->update_course()) {
            http_response_code(200);
            $result = array('Message' => 'Course updated');
        } else {
            http_response_code(500);
            $result = array('Message' => 'Failed to update course');
        }
        break;

    case 'DELETE': // case for DELETE request
        $id = file_get_contents('php://input'); // get id from php data stream

        if ($id) { // if id passed, delete specific item
            if ($course->delete_courses($id)) {
                http_response_code(200);
                $result = array('Message' => 'Course deleted');
            } else {
                http_response_code(404);
                $result = array('Message' => 'Failed to delete course');
            }
        } else { // if no id passed, delete all items
            if ($course->delete_courses()) {
                http_response_code(200);
                $result = array('Message' => 'All courses deleted');
            } else {
                http_response_code(500);
                $result = array('Message' => 'Failed to delete all courses');
            }
        }
        break;
}

echo json_encode($result); // display result
$pdo = null; // unset database connection variable
?>