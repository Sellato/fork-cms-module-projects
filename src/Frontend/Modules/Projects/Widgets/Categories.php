<?php

namespace Frontend\Modules\Projects\Widgets;

use Frontend\Core\Engine\Base\Widget as FrontendBaseWidget;
use Frontend\Modules\Projects\Engine\Model as FrontendProjectsModel;
use Frontend\Modules\Projects\Engine\Categories as FrontendProjectsCategoriesModel;

class Categories extends FrontendBaseWidget
{
    /**
     * Execute the extra
     */
    public function execute()
    {
        parent::execute();
        $this->loadTemplate();
        $this->parse();
    }

    /**
     * Parse
     */
    private function parse()
    {
        $this->tpl->assign('widgetProjectsCategories', FrontendProjectsCategoriesModel::getAll(array('parent_id' => 0)));
    }
}
