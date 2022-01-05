<?php
/**
 * Bootstrap - start de plugin taken
 * Doorloop de pagina en vevang {pluginname param1="param1" param2="param2" ......}
 * door uitvoer van plugin
 */
namespace verhuiskalender;
class Bootstrap
{
	const PLUGINNAME = 'verhuiskalender';
	const NAMESPACE = 'verhuiskalender';
	public function init($text)
	{
		echo($this->LoadScripts());	#loas css and javascripts

		$this->autoloader();	#start autoloader for loading classes automatically
		$this->loadclasses();	# dan maar even alles
		$this->loadfunctions();	# require all functions
		$main = new main;
		//
		// pluginlink zonder argumenten
		//
		$args=array();
		if(strpos($text,'{' . self::PLUGINNAME . '}',))
		{
			$text = str_replace('{'.self::PLUGINNAME.'}', $main->init($args), $text);
		}
		//
		// pluginlink met argumenten
		//
		if (preg_match_all('/\{' . self::PLUGINNAME . '\ ([^\}]+)\}/', $text, $matches))
		{
			foreach ($matches[1] as $matchIndex => $match)
			{
				$tag = $matches[0][$matchIndex];
				$tagArgs = $this->convertTagArgs($match);
				$args = array();
				foreach ($tagArgs as $k => $v) {
					$args[$k] = $v;
				}
				$text = str_replace($tag, $main->init($args), $text);
			}
		}
		return $text;
	}
	//
	// autoloader for the classes defined in map classes
	// De bestanden worden automatisch geinclude als class wordt aangemaakt
	// TODO: Werkt alleen in bootstrap.
	//
	protected function autoloader()
	{
		spl_autoload_register(function ($class_name)
		{
			$self = new self();
			#echo "class=" . $class_name;
			$parts = explode( '\\', $class_name );
			if($parts[0] == $self::NAMESPACE)
			{
				$classfile=$this->ClassFile($parts[1]);
				require_once( dirname( __FILE__ ) . $classfile );
			}
		});
	}
	#
	# check if class file exists
	#
	public static function ClassFile($class)
	{
		$dirs=array("classes");
		$class=strtolower($class);
		#echo "zoek class";
		foreach($dirs as $d)
		{
			$classfile = '/' . $d . '/' . $class . '.php';
			#echo "<br>file=".dirname( __FILE__ ) .$classfile;
			if(file_exists(dirname( __FILE__ ) . $classfile)) return($classfile);
		}
		return("");
	}
	protected function loadclasses() {
		$files = glob( dirname(__FILE__) . '/classes/*.php' );
		foreach ( $files as $file ) {
			require_once $file;
		}
	}
	/**
	 * Method to convert a string into an argument array
	 *
	 * @param   string  $tagArgs  String to convert into an array
	 *
	 * @return array
	 */
	/** Laadt functiebestanden */
	protected function loadfunctions() {
		$files = glob( dirname(__FILE__) . '/functions/*.php' );
		foreach ( $files as $file ) {
			require_once $file;
		}
	}
	protected function convertTagArgs($tagArgs)
	{
		$args = array();
		preg_match_all('/([\w]+=\"[a-zA-Z0-9 _#\/.,-]+\")/',$tagArgs, $namevalues);
		foreach ($namevalues[1] as $nameIndex => $name)
		{
			$namevalue = $namevalues[0][$nameIndex];
			//echo "namevalue=". $namevalue;
			$namevalue = explode('=', $namevalue);
			$name = $namevalue[0];
			$value = $namevalue[1];
			$value = preg_replace('/(["]+)/', '', $value);
			//echo "name =". $name . "value =". $value;
			$args[$name] = $value;
		}
		return $args;
	}
	protected function LoadScripts() 
	{
		$html = '';
		#$self = new self();
		$cssurl=\JURI::base(). "plugins/system/". self::PLUGINNAME ."/css/";
		$jsurl=\JURI::base(). "plugins/system/". self::PLUGINNAME ."/javascript/";
		$html .= '<meta charset="utf-8">';
  		$html .= '<meta name="viewport" content="width=device-width, initial-scale=1">';
		$html .= '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">';
		$html .= '<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>';
  		$html .= '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>';
  		$html .= '<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>';
		/**
		 * https://www.datatables.net/
		 */
		#$html .= '<script src="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css"></script>';	#DataTables is a plug-in for the jQuery Javascript library.
		#$html .= '<link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">'; #dataTables css file

		$html .= '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">';
		$html .= '<script src="https://code.jquery.com/jquery-1.12.4.js"></script>';
		$html .= '<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>';   #datepicker!!
		/**
		 * timepicker plugin
		 * https://timepicker.co/
		 */
		$html .= '<script src="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>';	#timepicker
		$html .= '<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">';

		$html .= '<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">';
		$html .= '<link rel="stylesheet" href="' . $cssurl . 'prana.css' . '">';
		$html .= '<link rel="stylesheet" href="' . $cssurl . 'forms.css' . '">';
		$html .= '<link rel="stylesheet" href="' . $cssurl . 'calender.css' . '">';
		$html .= '<link rel="stylesheet" href="' . $cssurl . 'compacttable.css' . '">';
		$html .= '<script src="' . $jsurl . 'planning.js' . '"></script>';	// scripts speciaal voor deze plugin
		$html .= '<script src="' . $jsurl . 'forms.js' . '"></script>';		// pranamas functies voor formulieren.
		#$html .= '<link rel="stylesheet" href="/resources/demos/style.css">';
		#$html .= '<script src="https://code.jquery.com/jquery-1.12.4.js"></script>';
		#$html .= '<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>';   #datepicker!!
		return($html);
    }
}
?>