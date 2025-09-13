# Overview
The class `InventoryItem` is responsible for updating the value of various items in an e-commerce system. Each item has a name, a value and a "sell in" property which denotes the number of days remaining before the product should be sold. Every day, the method ageByOneDay() is called on each item instance to update its value. The rules by which an item's value changes every day differ depending on the type of item:

* **Default items**: they decrease in value by 1 every day, but once the sell-in period has expired they start decreasing in value by 2 every day.
* **Vintage Wine**: this increases in value by 2 each day.
* **World Cup Tickets**: this increases in value each day according to the following rules:
  * If there are more than 10 days left, increases by 1 each day
  * If there are 10-6 days left, increases by 2
  * If there are 5 days or fewer left, increases by 3
  * If there are 0 days left, the value of the item drops to 0
* **Perishable items**: these work like default items but they degrade twice as fast (i.e. 2 per day within sell period, 4 per day afterwards)
* **Gold bar**: this is a special item whose value is always 80 and never changes.

General rules for value are:
* Value can never go below 0 for any item
* Value can never go above 50 (other than the Gold Bar)

## Exercise                                                                                        
* Look at the provided implementation of InventoryItem and provide a brief code review i.e. describe briefly what's bad about it.
* Refactor this to sensible object-oriented code
* Add a new Inventory class to track inventory items instead of the $items array
* Add functionality that can give the value of all inventory items for a given number of days ahead

**Notes:**
* Senior submissions should have automated tests
* This is your opportunity to show us what you can do! We’re not just looking for a functionally complete test.
* Don't worry about persisting the state of the objects (e.g. in a database).


## Usage

- To see the value of the items over 10 days, run: 
```sh
php application.php
```

- If you uncomment the relevant block of code in `application.php`, you will see a simulation of the value of the items over the next 50 days.

## Testing

-to check if all tests pass successfully, run:
```sh
composer run-script tests
```
