<?php

namespace App\Service;

class TestEmailService
{

	public function testEmail($email)
	{
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
			return 1;
		} else {
			return 0;
		}
	}
}