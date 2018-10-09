<?php

namespace App\Service;

class TestEmailService
{

	public function __construct() {

	}

	public function test($email)
	{
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
			return 1;
		} else {
			return 0;
		}
	}
}