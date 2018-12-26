<?php

namespace Drupal\todo\Controller;

use Drupal\Core\Controller\ControllerBase;

class TodoListController extends ControllerBase
{
  public function list() {
    
    $header = ['Todo', 'Priority'];
    $rows = [];

    $connection = \Drupal::database();

    $query = $connection->query("SELECT text, priority, status FROM todo_data");
    $result = $query->fetchAll();

    foreach($result as $row) {
        $rows[] = [
            $row->text,
            $row->priority,
        ];
    }

    return array(
    '#type' => 'table',
    '#header' => $header,
    '#rows' => $rows,
    );
  }
}