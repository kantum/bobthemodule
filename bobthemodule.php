<?php
if (!defined('_PS_VERSION_')) {
    exit;
}

class BobTheModule extends Module //It can just as well extend any class derived from Module, for specific needs: PaymentModule, ModuleGridEngine, ModuleGraph, etc.
{
    public function __construct()
    {
        $this->name = 'bobthemodule';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Kantum';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = [
            'min' => '1.6',
            'max' => _PS_VERSION_
        ];
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Bob the module');
        $this->description = $this->l('Bob is a module that allow your shop to make so much money that you will have to hide from girls wanting you');

        $this->confirmUninstall = $this->l('Uninstalling this module is like renouncing to hapiness, are you sure to commit this nonsense?!');

        if (!Configuration::get('MYMODULE_NAME')) {
            $this->warning = $this->l('No name provided');
        }

    }

    public function install()
    {
        if (Shop::isFeatureActive()) {
            Shop::setContext(Shop::CONTEXT_ALL);
        }

        if (!parent::install() ||
            !$this->registerHook('leftColumn') ||
            !$this->registerHook('header') ||
            !$this->registerHook('actionFrontControllerSetMedia') ||
            !Configuration::updateValue('MYMODULE_NAME', 'Bob') ||
            !Configuration::updateValue('BOBDOGNAME', 'Rocky') ||
            !Configuration::updateValue('BOBCATNAME', 'Fritz')
        ) {
            return false;
        }

        return true;
    }

    public function uninstall()
    {
        if (!parent::uninstall() ||
            !Configuration::deleteByName('MYMODULE_NAME') ||
            !Configuration::deleteByName('BOBDOGNAME') ||
            !Configuration::deleteByName('BOBCATNAME')
        ) {
            return false;
        }

        return true;
    }

    public function getContent()
    {
        $output = null;

        if (Tools::isSubmit('submit'.$this->name)) {
            $myModuleName = strval(Tools::getValue('MYMODULE_NAME'));
            $bobDogName = strval(Tools::getValue('BOBDOGNAME'));
            $bobCatName = strval(Tools::getValue('BOBCATNAME'));

            if (
                !$myModuleName ||
                empty($myModuleName) ||
                !Validate::isGenericName($myModuleName)
            ) {
                $output .= $this->displayError($this->l('Invalid Configuration value'));
            } else {
                Configuration::updateValue('MYMODULE_NAME', $myModuleName);
                $output .= $this->displayConfirmation($this->l('Settings updated'));
            }
            if (
                !$bobDogName ||
                empty($bobDogName) ||
                !Validate::isGenericName($bobDogName)
            ) {
                $output .= $this->displayError($this->l('Invalid Configuration value'));
            } else {
                Configuration::updateValue('BOBDOGNAME', $bobDogName);
                $output .= $this->displayConfirmation($this->l('Settings updated'));
            }
            if (
                !$bobCatName ||
                empty($bobCatName) ||
                !Validate::isGenericName($bobCatName)
            ) {
                $output .= $this->displayError($this->l('Invalid Configuration value'));
            } else {
                Configuration::updateValue('BOBCATNAME', $bobCatName);
                $output .= $this->displayConfirmation($this->l('Settings updated'));
            }
        }

        return $output.$this->displayForm();
    }

    public function displayForm()
    {
        // Get default language
        $defaultLang = (int)Configuration::get('PS_LANG_DEFAULT');

        // Init Fields form array
        $fieldsForm[0]['form'] = [
            'legend' => [
                'title' => $this->l('Settings'),
            ],
            'input' => [
                [
                    'type' => 'text',
                    'label' => $this->l('Configuration value'),
                    'name' => 'MYMODULE_NAME',
                    'size' => 20,
                    'required' => true
                ],
                [
                    'type' => 'text',
                    'label' => $this->l('Dog name'),
                    'name' => 'BOBDOGNAME',
                    'size' => 20,
                    'required' => true
                ],
                [
                    'type' => 'text',
                    'label' => $this->l('Cat name'),
                    'name' => 'BOBCATNAME',
                    'size' => 20,
                    'required' => true
                ]
            ],
            'submit' => [
                'title' => $this->l('Save'),
                'class' => 'btn btn-default pull-right'
            ]
        ];

        $helper = new HelperForm();

        // Module, token and currentIndex
        $helper->module = $this;
        $helper->name_controller = $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;

        // Language
        $helper->default_form_language = $defaultLang;
        $helper->allow_employee_form_lang = $defaultLang;

        // Title and toolbar
        $helper->title = $this->displayName;
        $helper->show_toolbar = true;        // false -> remove toolbar
        $helper->toolbar_scroll = true;      // yes - > Toolbar is always visible on the top of the screen.
        $helper->submit_action = 'submit'.$this->name;
        $helper->toolbar_btn = [
            'save' => [
                'desc' => $this->l('Save'),
                'href' => AdminController::$currentIndex.'&configure='.$this->name.'&save'.$this->name.
                '&token='.Tools::getAdminTokenLite('AdminModules'),
            ],
            'back' => [
                'href' => AdminController::$currentIndex.'&token='.Tools::getAdminTokenLite('AdminModules'),
                'desc' => $this->l('Back to list')
            ]
        ];

        // Load current value
        $helper->fields_value['MYMODULE_NAME'] = Tools::getValue('MYMODULE_NAME', Configuration::get('MYMODULE_NAME'));
        $helper->fields_value['BOBDOGNAME'] = Tools::getValue('BOBDOGNAME', Configuration::get('BOBDOGNAME'));
        $helper->fields_value['BOBCATNAME'] = Tools::getValue('BOBCATNAME', Configuration::get('BOBCATNAME'));

        return $helper->generateForm($fieldsForm);
    }

    public function hookDisplayLeftColumn($params)
    {
        $this->context->smarty->assign([
            'my_module_name' => Configuration::get('MYMODULE_NAME'),
            'bob_dog_name' => Configuration::get('BOBDOGNAME'),
            'bob_cat_name' => Configuration::get('BOBCATNAME'),
            'my_module_link' => $this->context->link->getModuleLink('bobthemodule', 'display'),
            'my_module_message' => $this->l('This is a super simple text message') // Do not forget to enclose your strings in the l() translation method
        ]);

        return $this->display(__FILE__, 'bobthemodule.tpl');
    }

    public function hookDisplayRightColumn($params)
    {
        return $this->hookDisplayLeftColumn($params);
    }

    public function hookActionFrontControllerSetMedia()
    {
        $this->context->controller->registerStylesheet(
            'bobthemodule-style',
            $this->_path.'views/css/bobthemodule.css',
            [
                'media' => 'all',
                'priority' => 1000,
            ]
        );

        $this->context->controller->registerJavascript(
            'bobthemodule-javascript',
            $this->_path.'views/js/bobthemodule.js',
            [
                'position' => 'bottom',
                'priority' => 1000,
            ]
        );
    }
}
