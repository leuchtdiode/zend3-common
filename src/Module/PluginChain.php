<?php
namespace Common\Module;

class PluginChain
{
	/**
	 * @var Plugin[]
	 */
	private $plugins;

	/**
	 * @return PluginChain
	 */
	public static function create()
	{
		return new self();
	}

	/**
	 * @param Plugin $plugin
	 * @return $this
	 */
	public function addPlugin(Plugin $plugin)
	{
		$this->plugins[] = $plugin;

		return $this;
	}

	/**
	 *
	 */
	public function executeAll()
	{
		foreach ($this->plugins as $plugin)
		{
			$plugin->execute();
		}
	}
}