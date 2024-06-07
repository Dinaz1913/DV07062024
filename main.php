<?php
	
	namespace Warehouse\src;
	require __DIR__ . '/vendor/autoload.php';
	
	use Reelz\Warehouse\UserManager;
	use Reelz\Warehouse\WarehouseManager;

	function displayMenu(): void
	{
        echo "1. Add Product\n";
        echo "2. Update Product Amount\n";
        echo "3. Withdraw Product\n";
        echo "4. Delete Product\n";
        echo "5. List Products\n";
        echo "6. Generate Report\n";
        echo "7. Exit\n";
        echo "Select an option: ";
	}

	$userManager = new UserManager();
	$warehouseManager = new WarehouseManager();

	$username = readline( "Enter your username: ");
	$accessCode = readline("Enter your access code: ");
	
	if (!$userManager->authenticate($username, $accessCode)) {
		echo "Authentication failed. Exiting...\n";
		exit;
	}
	
	echo "Authentication successful. Welcome, $username!\n";
	
	while (true) {
		displayMenu();
		$choice = readline("choose case: ");
		
		switch ($choice) {
			case '1':
				$name =
                    readline("Enter product name: ");
				$amount =
                    readline("Enter amount of units: ");
                $price =
                    (float)readline("Enter product price: ");
                $expirationDate =
                    readline("Enter quality expiration date (optional): ");
				$warehouseManager->addProduct
                (
                    $name,
                    $amount,
                    $price,
                    $expirationDate ?: null
                );
				echo "Product added successfully.\n";
				break;
			
			case '2':
				$id = readline("Enter product ID to update: ");
				$amount = readline("Enter new amount of units: ");
				$warehouseManager->updateProductAmount($id, $amount);
				echo "Product amount updated successfully.\n";
				break;
			
			case '3':
				$id = readline("Enter product ID to withdraw from: ");
				$amount = readline("Enter amount to withdraw: ");
				$warehouseManager->withdrawProduct($id, $amount);
				echo "Product withdrawn successfully.\n";
				break;
			
			case '4':
				$id = readline("Enter product ID to delete: ");
				$warehouseManager->deleteProduct($id);
				echo "Product deleted successfully.\n";
				break;
			
			case '5':
				$products = $warehouseManager->getProducts();
				foreach ($products as $product) {
                    echo "ID: {$product->getId()},
                     Name: {$product->getName()},
                      Amount: {$product->getAmountOfUnits()},
                       Price: {$product->getPrice()}, 
                       Expiration Date: 
                       {$product->getQualityExpirationDate()}\n";
                }
				break;

            case '6':
                $warehouseManager->generateReport();
                break;
			
			case '7':
				echo "Exiting...\n";
				exit;
			
			default:
				echo "Invalid option. Please try again.\n";
				break;
		}
	}