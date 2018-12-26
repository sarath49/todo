<?php
namespace Drupal\todo\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Implements a simple form.
 */
class TodoAddForm extends FormBase{

    /**
     * Build Todo Form.
     * 
     * @param array $form
     *   Default form array structure.
     * @param FormStateInterface $form_state
     *   Object contaning current form state.
     */
    public function buildForm(array $form, FormStateInterface $form_state) {

        $form['text'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Add task'),
            '#description' => $this->t('Enter task to do'),
            '#required' => TRUE,
        ];

        $form['priority'] = [
            '#type' => 'select',
            '#title' => $this->t('Select priority'),
            '#options' => [
              'low' => $this->t('Low'),
              'normal' => $this->t('Normal'),
              'high' => $this->t('High'),
            ],
          ];

        $form['actions'] = [
            '#type' => 'actions',
        ];

        $form['actions']['submit'] = [
            '#type' => 'submit',
            '#value' => $this->t('Save'),
        ];

        return $form;
    }

    /**
     * Getter method for form id.
     */
    public function getFormId() {
        return 'todo_add_form';
    }

    /**
     * Implements form submit handler.
     * 
     * @param array $form
     *  The render array of currently build form.
     * @param FormStateInterface $form_state
     *  Object describing current form_state
     */
    public function submitForm(array &$form, FormStateInterface $form_state) {

        $connection = \Drupal\Core\Database\Database::getConnection('default');
        $connection->insert('todo_data')
          ->fields([
             'text' => $form_state->getValue('text'),
             'priority' => $form_state->getValue('priority')
         ])
          ->execute();
        drupal_set_message($this->t(' %text is added.', ['%text' => $form_state->getValue('text')]));
    }
}