<?php
class bobthemoduledisplayModuleFrontController extends ModuleFrontController
{
    public function initContent()
    {
        parent::initContent();
        $this->setTemplate('module:bobthemodule/views/templates/front/display.tpl');
    }
}
