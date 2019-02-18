<?php
namespace Common\Encryption;

class EncryptDecryptOptions
{
	/**
	 * @var string
	 */
	private $key;

	/**
	 * @var string
	 */
	private $iv;

	/**
	 * @return EncryptDecryptOptions
	 */
	public static function create()
	{
		return new self();
	}

	/**
	 * @return string
	 */
	public function getKey(): string
	{
		return $this->key;
	}

	/**
	 * @param string $key
	 * @return EncryptDecryptOptions
	 */
	public function setKey(string $key): EncryptDecryptOptions
	{
		$this->key = $key;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getIv(): string
	{
		return $this->iv;
	}

	/**
	 * @param string $iv
	 * @return EncryptDecryptOptions
	 */
	public function setIv(string $iv): EncryptDecryptOptions
	{
		$this->iv = $iv;
		return $this;
	}
}