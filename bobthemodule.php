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
            !Configuration::updateValue('MYMODULE_NAME', 'Bob')
        ) {
            return false;
        }
    
        return true;
    }

    public function uninstall()
    {
        if (!parent::uninstall() ||
            !Configuration::deleteByName('MYMODULE_NAME')
        ) {
            return false;
        }
    
        return true;
    }
}
