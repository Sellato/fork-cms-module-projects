<?php

namespace Backend\Modules\Projects\Actions;

use Backend\Core\Engine\Base\ActionDelete;
use Backend\Core\Engine\Model;
use Backend\Modules\Projects\Engine\Model as BackendProjectsModel;

/**
 * This is the delete-action, it deletes an item
 *
 * @author Frederik Heyninck <frederik@figure8.be>
 */
class Delete extends ActionDelete
{
    /**
     * Execute the action
     */
    public function execute()
    {
        $this->id = $this->getParameter('id', 'int');

        // does the item exist
        if ($this->id !== null && BackendProjectsModel::exists($this->id)) {
            parent::execute();
            $this->record = (array) BackendProjectsModel::get($this->id);
            Model::deleteThumbnails(FRONTEND_FILES_PATH . '/' . $this->getModule() . '/image', $this->record['image']);

            // delete extra_ids
            foreach ($this->record['content'] as $row) {
                Model::deleteExtraById($row['extra_id'], true);
            }

            BackendProjectsModel::delete($this->id);

            Model::triggerEvent(
                $this->getModule(), 'after_delete',
                array('id' => $this->id)
            );

            $this->redirect(
                Model::createURLForAction('Index') . '&report=deleted'
            );
        } else {
            $this->redirect(Model::createURLForAction('Index') . '&error=non-existing');
        }
    }
}
