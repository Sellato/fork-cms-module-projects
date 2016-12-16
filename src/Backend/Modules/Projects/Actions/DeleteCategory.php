<?php

namespace Backend\Modules\Projects\Actions;

use Backend\Core\Engine\Base\ActionDelete;
use Backend\Core\Engine\Model;
use Backend\Modules\Projects\Engine\Category as BackendProjectsCategoryModel;

/**
 * This is the delete-action, it deletes an item
 *
 * @author Frederik Heyninck <frederik@figure8.be>
 */
class DeleteCategory extends ActionDelete
{
    /**
     * Execute the action
     */
    public function execute()
    {
        $this->id = $this->getParameter('id', 'int');

        // does the item exist
        if ($this->id !== null && BackendProjectsCategoryModel::exists($this->id)) {
            parent::execute();
            $this->record = (array) BackendProjectsCategoryModel::get($this->id);

            // delete extra_ids
            foreach($this->record['content'] as $row){
                Model::deleteExtraById($row['extra_id'], true);
            }

            BackendProjectsCategoryModel::delete($this->id);

            Model::triggerEvent(
                $this->getModule(), 'after_category_delete',
                array('id' => $this->id)
            );

            $this->redirect(
                Model::createURLForAction('Categories') . '&report=deleted'
            );
        }
        else $this->redirect(Model::createURLForAction('Categories') . '&error=non-existing');
    }
}
