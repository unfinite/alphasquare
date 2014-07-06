<?php

class Views {

	public $links = array();

	public $zeam;

	function __construct(Zeam $ZeamEngine) {

		$this->zeam = $ZeamEngine;

	}

	function load_view($view) {

		$viewpath = ZEAM_VIEW_BASEDIR.'/'.$view.ZEAM_VIEW_SUFFIX;

		if (file_exists($viewpath)) {

			include($viewpath); 

		}

	}

	function add_link($name, $link) {

		$this->links[$name] = $link;

	}

	function get_link($link) {

		echo $this->links[$link];

	}
}


?>
