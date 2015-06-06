<?php

namespace LeanStack\CinetixxClient\Auth;

class Token {

	/**
	 * @access public
	 * @var string
	 */
	private $Login;
	/**
	 * @access public
	 * @var string
	 */
	private $Password;
	/**
	 * @access public
	 * @var string
	 */
	private $ClientVersion;
	/**
	 * @access public
	 * @var string
	 */
	private $SessionGuid;

	/**
	 * Token constructor.
	 * @param string $login
	 * @param string $password
	 */
	public function __construct($login, $password)
	{
		$this->Login = $login;
		$this->Password = $password;
	}
}