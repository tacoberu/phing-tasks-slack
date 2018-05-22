<?php

require_once "phing/types/DataType.php";


/**
 *	<taco.slack-config id="slack-config"
 *		url="https://hooks.slack.com/services/T0VPZRzzCM/B0dddd4S/kasdfasdfsadfasdfasdfasdfp0yM7ky"
 *		username="Devel"
 *		icon="mercurial"
 *		channel="#cesys-deploy"
 *		/>
 */
class TacoSlackConfigType extends DataType
{

	/**
	 * @var string
	 * Sets the URL part: mysql://localhost/mydatabase
	 */
	private $url;


	/**
	 * @var array
	 */
	private $settings = [
		'username' => 'Phing',
		'icon' => ':phing:',
	];


	/**
	 * Sets the URL part: mysql://localhost/mydatabase
	 *
	 * @param string
	 */
	function setUrl($url)
	{
		$this->url = $url;
	}



	function getUrl()
	{
		return $this->url;
	}



	/**
	 * @param string
	 */
	function setUsername($val)
	{
		$this->settings['username'] = $val;
	}



	/**
	 * @param string
	 */
	function setIcon($val)
	{
		$this->settings['icon'] = ':' . trim($val, ':') . ':';
	}



	/**
	 * @param string
	 */
	function setChannel($val)
	{
		$this->settings['channel'] = $val;
	}



	function getSettings()
	{
		return $this->settings;
	}



	/**
	 * Your datatype must implement this function, which ensures that there
	 * are no circular references and that the reference is of the correct
	 * type (DSN in this example).
	 *
	 * @return self
	 */
	function getRef(Project $p)
	{
		if ( !$this->checked ) {
			$stk = array();
			array_push($stk, $this);
			$this->dieOnCircularReference($stk, $p);
		}
		$o = $this->ref->getReferencedObject($p);

		if ( !($o instanceof self) ) {
			throw new BuildException($this->ref->getRefId()." doesn't denote a SlackConfig");
		}

		return $o;
	}


}
