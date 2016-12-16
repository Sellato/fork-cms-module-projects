<?php

namespace Backend\Modules\Projects\Installer;

use Backend\Core\Installer\ModuleInstaller;

/**
 * Installer for the Projects module
 *
 * @author Frederik Heyninck <frederik@figure8.be>
 */
class Installer extends ModuleInstaller
{
    public function install()
    {
        // import the sql
        $this->importSQL(dirname(__FILE__) . '/Data/install.sql');

        // install the module in the database
        $this->addModule('Projects');

        // install the locale, this is set here beceause we need the module for this
        $this->importLocale(dirname(__FILE__) . '/Data/locale.xml');

        $this->setModuleRights(1, 'Projects');

        $this->setActionRights(1, 'Projects', 'Add');
        $this->setActionRights(1, 'Projects', 'AddCategory');
        $this->setActionRights(1, 'Projects', 'AddImages');
        $this->setActionRights(1, 'Projects', 'Categories');
        $this->setActionRights(1, 'Projects', 'Delete');
        $this->setActionRights(1, 'Projects', 'DeleteCategory');
        $this->setActionRights(1, 'Projects', 'DeleteImage');
        $this->setActionRights(1, 'Projects', 'Edit');
        $this->setActionRights(1, 'Projects', 'EditCategory');
        $this->setActionRights(1, 'Projects', 'Index');

        $this->setActionRights(1, 'Projects', 'Sequence');
        $this->setActionRights(1, 'Projects', 'SequenceCategories');
        $this->setActionRights(1, 'Projects', 'SequenceImages');
        $this->setActionRights(1, 'Projects', 'UploadImages');
        $this->setActionRights(1, 'Projects', 'EditImage');
        $this->setActionRights(1, 'Projects', 'GetAllTags');

        $this->setActionRights(1, 'Projects', 'Settings');
        $this->setActionRights(1, 'Projects', 'GenerateUrl');
        $this->setActionRights(1, 'Projects', 'UploadImage');

        $this->makeSearchable('Projects');

        // add extra's
        $subnameID = $this->insertExtra('Projects', 'block', 'Projects', null, null, 'N', 1000);
        $this->insertExtra('Projects', 'block', 'ProjectDetail', 'Detail', null, 'N', 1001);
        $this->insertExtra('Projects', 'widget', 'Recent', 'RecentProjects', null, 'N', 1001);

        $navigationModulesId = $this->setNavigation(null, 'Modules');
        $navigationModulesId = $this->setNavigation($navigationModulesId, 'Projects');
        $this->setNavigation($navigationModulesId, 'Projects', 'projects/index', array('projects/add','projects/edit', 'projects/index', 'projects/add_images', 'projects/edit_image'), 1);
        $this->setNavigation($navigationModulesId, 'Categories', 'projects/categories', array('projects/add_category','projects/edit_category', 'projects/categories'), 2);

         // settings navigation
        $navigationSettingsId = $this->setNavigation(null, 'Settings');
        $navigationModulesId = $this->setNavigation($navigationSettingsId, 'Modules');
        $this->setNavigation($navigationModulesId, 'Projects', 'projects/settings');
    }
}
