<?php

namespace Frontend\Modules\Projects\Widgets;


use Frontend\Core\Engine\Base\Widget as FrontendBaseWidget;
use Frontend\Modules\Projects\Engine\Model as FrontendProjectsModel;


class Project extends FrontendBaseWidget
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
        if(isset($this->data['id'])) $this->tpl->assign('widgetProjectsProject', FrontendProjectsModel::getById($this->data['id']));
    }
}
