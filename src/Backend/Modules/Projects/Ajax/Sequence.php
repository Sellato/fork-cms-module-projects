<?php

namespace Backend\Modules\Projects\Ajax;

use Backend\Core\Engine\Base\AjaxAction;
use Backend\Modules\Projects\Engine\Model as BackendProjectsModel;

/**
 * Alters the sequence of Projects articles
 *
 * @author Frederik Heyninck <frederik@figure8.be>
 */
class Sequence extends AjaxAction
{
    public function execute()
    {
        parent::execute();

        // get parameters
        $newIdSequence = trim(\SpoonFilter::getPostValue('new_id_sequence', null, '', 'string'));

        // list id
        $ids = (array) explode(',', rtrim($newIdSequence, ','));

        $max = count($ids);
        
        // loop id's and set new sequence
        foreach ($ids as $i => $id) {
            $item['id'] = $id;
            $item['sequence'] = $max--;

            // update sequence
            if (BackendProjectsModel::exists($id)) {
                BackendProjectsModel::update($item);
            }
        }

        // success output
        $this->output(self::OK, null, 'sequence updated');
    }
}
