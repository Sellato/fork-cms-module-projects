<?php

namespace Backend\Modules\Projects\Actions;

use Backend\Core\Engine\Base\ActionIndex;
use Backend\Core\Engine\Authentication;
use Backend\Core\Engine\DataGridDB;
use Backend\Core\Language\Language;
use Backend\Core\Engine\Model;
use Backend\Modules\Projects\Engine\Model as BackendProjectsModel;
use Backend\Core\Engine\Form;
use Backend\Modules\Projects\Engine\Category as BackendProjectsCategoryModel;

/**
 * This is the index-action (default), it will display the overview of Projects posts
 *
 * @author Frederik Heyninck <frederik@figure8.be>
 */
class Index extends ActionIndex
{

    private $filter = [];

    /**
     * Execute the action
     */
    public function execute()
    {
        parent::execute();

        $this->setFilter();
        $this->loadForm();

        $this->loadDataGridProjects();
        $this->loadDataGridProjectsDrafts();
        $this->parse();
        $this->display();
    }

    /**
     * Load the dataGrid
     */
    protected function loadDataGridProjects()
    {
        $query = 'SELECT i.id, c.name,  i.sequence, i.hidden
         FROM projects AS i
         INNER JOIN project_content as c  on i.id = c.project_id';

        if(isset($this->filter['categories'] ) && $this->filter['categories'] !== null && count($this->filter['categories']))
        {
            $query .= ' INNER JOIN projects_linked_catgories AS cat ON i.id = cat.project_id';
        }

        $query .= ' WHERE 1';

        $parameters = array();
        $query .= ' AND c.language = ?';
        $parameters[] = Language::getWorkingLanguage();

        $query .= ' AND i.status = ?';
        $parameters[] = 'active';

        if($this->filter['value']){
            $query .= ' AND c.name LIKE ?';
            $parameters[] = '%' . $this->filter['value'] . '%';
        }

        if(isset($this->filter['categories'] ) && $this->filter['categories'] !== null && count($this->filter['categories']))
        {
            $query .= ' AND cat.category_id IN(' . implode(',', array_values($this->filter['categories'])) . ')';
        }

        $query .= 'GROUP BY i.id ORDER BY sequence DESC';

        $this->dataGridProjects = new DataGridDB(
            $query,
            $parameters
        );

        $this->dataGridProjects->enableSequenceByDragAndDrop();
        $this->dataGridProjects->setURL($this->dataGridProjects->getURL() . '&' . http_build_query($this->filter));

        $this->dataGridProjects->setColumnAttributes(
            'name', array('class' => 'title')
        );

        // check if this action is allowed
        if (Authentication::isAllowedAction('Edit')) {
            $this->dataGridProjects->addColumn(
                'edit', null, Language::lbl('Edit'),
                Model::createURLForAction('Edit') . '&amp;id=[id]',
                Language::lbl('Edit')
            );
            $this->dataGridProjects->setColumnURL(
                'name', Model::createURLForAction('Edit') . '&amp;id=[id]'
            );
        }
    }

    /**
     * Load the dataGrid
     */
    protected function loadDataGridProjectsDrafts()
    {
        $query = 'SELECT i.id, c.name,  i.sequence, i.hidden
         FROM projects AS i
         INNER JOIN project_content as c  on i.id = c.project_id';

        if(isset($this->filter['categories'] ) && $this->filter['categories'] !== null && count($this->filter['categories']))
        {
            $query .= ' INNER JOIN projects_linked_catgories AS cat ON i.id = cat.project_id';
        }

        $query .= ' WHERE 1';

        $parameters = array();
        $query .= ' AND c.language = ?';
        $parameters[] = Language::getWorkingLanguage();

        $query .= ' AND i.status = ?';
        $parameters[] = 'draft';



        if($this->filter['value']){
            $query .= ' AND c.name LIKE ?';
            $parameters[] = '%' . $this->filter['value'] . '%';
        }

        if(isset($this->filter['categories'] ) && $this->filter['categories'] !== null && count($this->filter['categories']))
        {
            $query .= ' AND cat.category_id IN(' . implode(',', array_values($this->filter['categories'])) . ')';
        }


        $query .= 'GROUP BY i.id ORDER BY sequence DESC';

        $this->dataGridProjectsDrafts = new DataGridDB(
            $query,
            $parameters
        );

        $this->dataGridProjectsDrafts->enableSequenceByDragAndDrop();
        $this->dataGridProjectsDrafts->setURL($this->dataGridProjectsDrafts->getURL() . '&' . http_build_query($this->filter));

        $this->dataGridProjects->setColumnAttributes(
            'name', array('class' => 'title')
        );

        // check if this action is allowed
        if (Authentication::isAllowedAction('Edit')) {
            $this->dataGridProjectsDrafts->addColumn(
                'edit', null, Language::lbl('Edit'),
                Model::createURLForAction('Edit') . '&amp;id=[id]',
                Language::lbl('Edit')
            );
            $this->dataGridProjectsDrafts->setColumnURL(
                'name', Model::createURLForAction('Edit') . '&amp;id=[id]'
            );
        }
    }

    /**
     * Load the form
     */
    private function loadForm()
    {
        $this->frm = new Form('filter', Model::createURLForAction(), 'get');

        $categories = BackendProjectsCategoryModel::getForMultiCheckbox();

        $this->frm->addText('value', $this->filter['value']);

        if(!empty($categories) && Authentication::isAllowedAction('AddCategory'))
        {
            $this->frm->addMultiCheckbox(
                'categories',
                $categories,
                '',
                'noFocus'
            );
        }

        // manually parse fields
        $this->frm->parse($this->tpl);
    }


    /**
     * Sets the filter based on the $_GET array.
     */
    private function setFilter()
    {
        $this->filter['categories'] = $this->getParameter('categories', 'array');
        $this->filter['value'] = $this->getParameter('value') == null ? '' : $this->getParameter('value');
    }


    /**
     * Parse the page
     */
    protected function parse()
    {
        // parse the dataGrid if there are results
        $this->tpl->assign('dataGridProjects', (string) $this->dataGridProjects->getContent());
        $this->tpl->assign('dataGridProjectsDraft', (string) $this->dataGridProjectsDrafts->getContent());
    }
}
