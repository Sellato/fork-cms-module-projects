<?php

namespace Frontend\Modules\Projects\Widgets;

use Frontend\Core\Engine\Base\Widget as FrontendBaseWidget;
use Frontend\Modules\Projects\Engine\Model as FrontendProjectsModel;

class Recent extends FrontendBaseWidget
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
        $this->tpl->assign('widgetProjectsRecent', FrontendProjectsModel::getAll($this->get('fork.settings')->get('Projects', 'overview_num_items_recent', 3)));
    }
}
