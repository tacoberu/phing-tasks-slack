<?php
/**
 * @author Martin Takáč <martin@takac.name>
 */

require_once 'phing/Task.php';


/**
 * Send msg to slack.
 * <taco.slack refid="slack-config">Hello world!</taco.slack>
 */
class TacoSlackTask extends Task
{

	/**
	 * @var string
	 */
	private $message = "No message";


	/**
	 * @var string
	 */
	private $channel;


	/**
	 * @var TacoSlackConfigType
	 */
	private $config;


	function setRefid(Reference $ref)
	{
		$this->config = $ref->getReferencedObject($this->project);
	}



	function setChannel($m)
	{
		$this->channel = (string) $m;
	}



	/**
	 * Supporting the <task>Message</task> syntax.
	 */
	function addText($msg)
	{
		$this->message = (string) $msg;
	}



	/**
	 * executes the Composer task
	 */
	function main()
	{
		$settings = $this->getConfig()->getSettings();
		if ($this->channel) {
			$settings['channel'] = $this->channel;
		}
		try {
			$client = new Maknz\Slack\Client($this->getConfig()->getUrl(), $settings);
			$client->send($this->message);
			//~ $this->log($this->message);
		}
		catch (\Exception $e) {
			throw new BuildException($e->getMessage());
		}
	}



	private function getConfig()
	{
		if (empty($this->config)) {
			throw new BuildException("Missing configuration.");
		}
		return $this->config;
	}

}
