<?php

require 'lib/Router.php';
require 'lib/Database.php';
require 'lib/utils.php';

session_start();

$database = new Database('localhost', 'root', '', 'todoapp');
$router = new Router();
$message = [];

$router->get('/', function () use ($database, $message) {
    $todoItems = $database->readTable('todo_items');

    $html = render('homepage.php', [
        'todoItems' => $todoItems,
        'msg' => $message
    ]);
    echo $html;
});

$router->post('/', function () use ($database) {
    if (!isset($_POST['title']) || !isset($_POST['desc'])) {
        $message = [
            'type' => 'error',
            'msg' => 'Please complete all fields'
        ];
    } else {
        $title = $_POST['title'];
        $description = $_POST['desc'];

        $inserted = $database->writeRecord('todo_items', [
            'title' => $title,
            'description' => $description
        ]);

        if ($inserted) {
            redirect('/');
        } else {
            $message = [
                'type' => 'error',
                'msg' => 'Failed to add todo item'
            ];
        }
    }

    redirect('/');
});

$router->post('/update', function () use ($database) {
    if (!isset($_POST['id']) || !isset($_POST['title']) || !isset($_POST['desc'])) {
        $message = [
            'type' => 'error',
            'msg' => 'Please complete all fields'
        ];
    } else {
        $id = $_POST['id'];
        $title = $_POST['title'];
        $description = $_POST['desc'];

        $updated = $database->updateRecord('todo_items', [
            'title' => $title,
            'description' => $description
        ], "id = {$id}");

        if ($updated) {
            $message = [
                'type' => 'success',
                'msg' => 'Todo item updated successfully'
            ];
        } else {
            $message = [
                'type' => 'error',
                'msg' => 'Failed to update todo item'
            ];
        }
    }

    redirect('/');
});

$router->post('/delete', function () use ($database) {
    if (!isset($_POST['id'])) {
        $message = [
            'type' => 'error',
            'msg' => 'ID not specified'
        ];
    } else {
        $id = $_POST['id'];
        $deleted = $database->deleteRecord('todo_items', "id = {$id}");

        if ($deleted) {
            $message = [
                'type' => 'success',
                'msg' => 'Todo item deleted successfully'
            ];
        } else {
            $message = [
                'type' => 'error',
                'msg' => 'Failed to delete todo item'
            ];
        }
    }

    redirect('/');
});

$router->get('/404', function () {
    echo "Page not found 404";
});

$router->run();