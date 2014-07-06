<?php

class Modules {

	public $zeam;

	function __construct(Zeam $ZeamEngine) {

		$this->zeam = $ZeamEngine;

	}

	function load_module($module) {
		
		$modulepath = ZEAM_MODULE_BASEDIR.'/'.$module.ZEAM_MODULE_SUFFIX;

		$descpath = ZEAM_MODULE_BASEDIR.'/'.$module.DESC_SUFFIX;

		if (file_exists($modulepath) and file_exists($descpath)) {

			include ($modulepath);

		} else {
			$this->zeam->log("Couldn't add module. Are you sure the desc file is in, and that the files exist? Are the permissions correct?");
		}

	}


}


class Module {

	function module_info($module) {

		$descpath = ZEAM_MODULE_BASEDIR.'/'.$module.DESC_SUFFIX;
		$desc = file($descpath);
		
		// get information

		$module_name = $desc[1];
		$module_version = $desc[2];
		$module_author = $desc[3];
		$module_description = $desc[4];
	}

}


?>
