<?php
	
	namespace Reelz\Warehouse;
	
	class UserManager
	{
		private array $users = [];
		
		public function __construct()
		{
			$this->loadUsers();
		}
		
		public function authenticate
        (string $username,
         string $accessCode
        ): bool
		{
			foreach ($this->users as $user) {
				if ($user->getUsername()
                    === $username
                    && $user->getAccessCode()
                    === $accessCode)
                {
					return true;
				}
			}
			return false;
		}

        private function loadUsers(): void
        {
            $filePath = __DIR__ . '/../data/user.json';

            if (!file_exists($filePath)) {
                echo "Warning: user.json file not found\n";
                return;
            }

            $data =
                json_decode(file_get_contents
                ($filePath), true);

            if (!isset($data['users'])
                || !is_array($data['users'])) {
                echo "Warning: No users found in user.json\n";
                return;
            }

            foreach ($data['users'] as $userData) {
                $this->users[] = User::fromArray($userData);
            }
        }

    }
