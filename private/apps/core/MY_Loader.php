<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* load the MX_Loader class */
require APPPATH."third_party/MX/Loader.php";

class MY_Loader extends MX_Loader
{

	public function _ci_load($_ci_data)
	{
		extract($_ci_data);

		if (isset($_ci_view))
		{
			$_ci_path = '';

			/* add file extension if not provided */
			$_ci_file = (pathinfo($_ci_view, PATHINFO_EXTENSION)) ? $_ci_view : $_ci_view.EXT;

			foreach ($this->_ci_view_paths as $path => $cascade)
			{
				if (file_exists($view = $path.$_ci_file))
				{
					$_ci_path = $view;
					break;
				}
				if ( ! $cascade) break;
			}
		}
		elseif (isset($_ci_path))
		{

			$_ci_file = basename($_ci_path);
			if( ! file_exists($_ci_path)) $_ci_path = '';
		}

		if (empty($_ci_path))
			show_error('Unable to load the requested file: '.$_ci_file);

		if (isset($_ci_vars))
			$this->_ci_cached_vars = array_merge($this->_ci_cached_vars, (array) $_ci_vars);

		extract($this->_ci_cached_vars);

		ob_start();

			include($_ci_path);

		log_message('debug', 'File loaded: '.$_ci_path);

		if ($_ci_return == TRUE) return ob_get_clean();

		if (ob_get_level() > $this->_ci_ob_level + 1)
		{
			ob_end_flush();
		}
		else
		{
			CI::$APP->output->append_output(ob_get_clean());
		}
	}

	/** Load a module view **/
	public function view($view, $vars = array(), $return = FALSE)
	{
		list($path, $_view) = Modules::find($view, $this->_module, 'views/');

		if ($path != FALSE)
		{
			$this->_ci_view_paths = array($path => TRUE) + $this->_ci_view_paths;
			$view = $_view;
		}

		return $this->_ci_load(array('_ci_view' => $view, '_ci_vars' => ((method_exists($this,'_ci_object_to_array')) ? $this->_ci_object_to_array($vars) : $this->_ci_prepare_view_vars($vars)), '_ci_return' => $return));
	}
}