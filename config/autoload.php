<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2018 Leo Feyer
 *
 * @license LGPL-3.0+
 */


/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
	'Blioxxx',
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Classes
	'Blioxxx\Gallery\database' => 'system/modules/bx-galiere/classes/database.php',

	// Modules
	'ModuleBXGalerie'          => 'system/modules/bx-galiere/modules/ModuleBXGalerie.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'mod_bx_gallery' => 'system/modules/bx-galiere/templates',
));
