<?php
#######################################################################
#
# SCRIPT INFORMATION                                          TVDGREFT
# Name          :VERHUISKALENDER
# Type			:system plugin VERHUISKALENDER
#
#
#######################################################################
defined('_JEXEC') or die;
use VERHUISKALENDER as KALENDER;
jimport('joomla.plugin.plugin');

/**
 * Class plgSystemevent
 *
 */
class PlgSystemVERHUISKALENDER extends JPlugin
{
	protected $autoloadLanguage = true;
	/**
	 * Constructor.
	 *
	 * @param   object  &$subject  The object to observe.
	 * @param   array   $config    An optional associative array of configuration settings.
	 */
	public function __construct(& $subject, $config)
	{
		parent::__construct($subject, $config);
	}

	/**
	 * Event method onAfterRender
	 *
	 * @return null
	 */
	

	/**
	 * Method to replace tags in a text
	 * {bookevent event=eventcode}
	 * @param   string  $text  Text to replace tags in
	 *
	 * @return mixed
	 */
	public function onAfterRender()
	{
		require_once dirname( __FILE__ ) . '/bootstrap.php';
		$bootstrap = new KALENDER\Bootstrap();
		$application = JFactory::getApplication();
		if ($application->isSite() == false)
		{
			return;
		}
		$body = $bootstrap->init($application->getBody());
		$application->setBody($body);
	}
}
?>