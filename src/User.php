<?php
	
	namespace Reelz\Warehouse;
	
	class User
	{
		private string $username;
		private string $accessCode;
		
		public function __construct
        (
            string $username,
            string $accessCode
        )
		{
			$this->username = $username;
			$this->accessCode = $accessCode;
		}
		
		public function getUsername(): string
		{
			return $this->username;
		}
		
		public function getAccessCode(): string
		{
			return $this->accessCode;
		}
		
		public function toArray(): array
		{
			return [
				'username' => $this->username,
				'accessCode' => $this->accessCode,
			];
		}
		
		public static function fromArray(array $data): self
		{
			return new self($data['username'],
                $data['accessCode']);
		}
	}
