<?php
namespace Common\Encryption;

use Exception;
use function extension_loaded;

class EncryptDecryptHandler
{
	const ENCRYPT_METHOD = 'AES-256-CBC';

	/**
	 * @var string
	 */
	private $key;

	/**
	 * @var string
	 */
	private $iv;

	/**
	 * @param $text
	 * @param EncryptDecryptOptions $options
	 * @return string
	 * @throws Exception if openssl extension is missing
	 */
	public function encrypt($text, EncryptDecryptOptions $options)
	{
		$this->prepare($options);

		$encrypted = openssl_encrypt(
			$text,
			self::ENCRYPT_METHOD,
			$this->key,
			0,
			$this->iv
		);

		return base64_encode($encrypted);
	}

	/**
	 * @param $text
	 * @param EncryptDecryptOptions $options
	 * @return string
	 * @throws Exception if openssl extension is missing
	 */
	public function decrypt($text, EncryptDecryptOptions $options)
	{
		$this->prepare($options);

		return openssl_decrypt(
			base64_decode($text),
			self::ENCRYPT_METHOD,
			$this->key,
			0,
			$this->iv
		);
	}

	/**
	 * @param EncryptDecryptOptions $options
	 * @throws Exception
	 */
	private function prepare(EncryptDecryptOptions $options)
	{
		if (!extension_loaded('openssl'))
		{
			throw new Exception('Extension openssl is mandatory to use this handler');
		}

		// hash
		$this->key = hash('sha256', $options->getKey());

		// iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
		$this->iv = substr(hash('sha256', $options->getIv()), 0, 16);
	}
}