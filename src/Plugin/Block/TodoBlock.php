<?php

namespace Drupal\todo\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Cache\Cache;

/**
 * Provides a Todo block.
 *
 * @Block(
 *   id = "todo_block",
 *   admin_label = @Translation("Todo block"),
 * )
 */
class TodoBlock extends BlockBase {
  // Override BlockPluginInterface methods here.

  /**
   * {@inheritdoc}
   */
  public function build() {

    $header = ['Todo', 'Priority'];
    $rows = [];
  
    $connection = \Drupal::database();
  
    $query = $connection->query("SELECT text, priority, status FROM todo_data WHERE date = :today", 
        [':today' => strtotime(date('Y-m-d'))]);
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
        '#cache' => array(
          'tags' => $this->getCacheTags(),
          'contexts' => $this->getCacheContexts(),
        ),
      );  
    }

    /**
     * {@inheritdoc}
     */
    public function getCacheTags() {
      if ($user = \Drupal::currentUser()) {
        return Cache::mergeTags(parent::getCacheTags(), array('user:' . $user->id()));
      } else {
        return parent::getCacheTags();
      }
    }
      
    /**
     * {@inheritdoc}
     */
    public function getCacheContexts() {
      return Cache::mergeContexts(parent::getCacheContexts(), array('user'));
    }
}
