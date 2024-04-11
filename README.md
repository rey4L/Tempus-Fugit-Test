# Quick Setup Guide

1. **Extract** the `Tempus_Fugit_Project` folder into the `htdocs` directory, or use `git clone` to clone the repository from [github.com/rey4L/Tempus_Fugit_Project](https://github.com/rey4L/Tempus_Fugit_Project.git) into `htdocs`.
2. **Start** PHP and MySQL in XAMPP.
3. **Create** a database named `karens_kitchen` in PhpMyAdmin. _If the `karens_kitchen` database already exists, please drop all tables to facilitate database initialization._
4. **Navigate** to the `/Tempus_Fugit_Project` directory.

## User Accounts

To access the system, you must first register for a user account. Please be aware of several rules:

1. Registration requires a valid employee ID. Initially, employees with IDs 1, 2, and 3 are set up.
2. There is a one-to-one relationship between an employee and a user account, meaning only one account can be created per employee.
3. An employee's job role determines their eligibility for a manager or cashier role. Employees with IDs 1 and 2 are eligible for both roles, while employee 3 is only eligible for the cashier role.
4. Access to certain pages depends on an employee's role, e.g. A cashier can only access the register and bill pages.
5. The same email cannot be used for multiple accounts.
6. Passwords must be strong (*i.e., it must have a minimum length of 8 characters, contain at least 1 uppercase, 1 lowercase, 1 special character and 1 number*).

_N.B._ The design is not an exact match to the final outcome but is similar enough to give an idea of what the website should look like.

## Graphs

Graphs are accessible via the menu tab. They will display data only after items have been sold. To view the graphs, first use the register to create bills.

Note: For the graph labeled `Items Sold`, it is recommended not to select the same start and end date. This will render a line graph with a single data point.

## Known / Notable Bug Fixes and Improvements

- The image URL field for adding new menu items is now functional.
- Data stored in the register, prior to confirming, is now preserved even if the browser is closed or the session is deleted, preventing the creation of unused empty bills.
- Unnecessary number values such as `INT(20)` in the database have been removed.
- Database initialization in `Database.php` no longer relies on a session to prevent duplicate inputs. Instead, an `IGNORE` SQL statement and a cookie are used. See [Database Initialization](#database-initialization).
- `config.json` has been created to manage `GET` and `POST` permissions and user role privileges.
- All additional requirements have been satisfied.

## Database Initialization

The project automatically initializes the database with data on the first run. To reinitialize the database, if necessary, follow these steps:

1. **Drop** existing tables in the `karens_kitchen` database.
2. **Delete** the `init` cookie:
    - Open the browser's inspect tool.
    - Navigate to the Application Tab.
    - Locate and delete the `init` session cookie.

Note: The application initializes only menu items and employees. To view bills in the bill tab, create them using the cash register interface.

Also, note that with the set database values, the maximum price and total is 999999999999999999999999.99999. Therefore, if a number higher than this is entered as the price for an item, it will result in a calculation error. This is due to database value limitations, not a mathematical error.

## Configuration Settings

To run the project in a subdirectory within `htdocs`, adjust the global variables `BASE_URL`, `RESOURCE_PATH`, and `CSS_PATH` in `inc/core/config.php`.

For example, to run the application from a subfolder named `personal` (located within `htdocs` and containing the `Tempus_Fugit_Project` folder), modify the global variables as follows:

#### Example Folder Structure:

```
htdocs
├── personal
    └── Tempus_Fugit_Project
```

1. `BASE_URL = "/personal/Tempus_Fugit_Project";`
2. `CSS_PATH = "http://localhost/personal/Tempus_Fugit_Project/public/css/";`
3. `RESOURCE_URL = "http://localhost/personal/Tempus_Fugit_Project/public/images/";`

Note: `inc/core/config.php` is where database configurations are set. If desirable, go here to change database settings.

## CSS Loading Issues

If webpage styling isn't appearing, follow these steps:

1. Go to your browser's settings.
2. Search for and select the option to clear browsing history.
3. Specifically, choose to clear _Cache images and files_ (instructions based on the Chrome Web Browser).
4. Reload the webpage.

_For a visual reference of the intended website design, please refer to the Figma file:_ [figma.com/file](https://www.figma.com/file/CpIRBICRaH4dku8PVfwDsJ/CSE3101_Design_Assigment_2?type=design&node-id=0%3A1&mode=design&t=FQXvdimrpZpFMqSp-1).

_N.B._ The design is not an exact match to the final outcome but is similar enough to give an idea of what the website should look like.

## Inserting Multiple Values

When inserting multiple values into fields like _othernames_ for employees or _tags_ and _ingredients_ for menu items, enter the values separated by commas without spaces, e.g., "tag1,tag2,tag3". Info bubble icons next to such fields provide instructions when hovered over.

Info bubbles generally offer guidance for the user.

## Understanding Action Buttons

For clarity on the function of each action button, hover your cursor over them. A brief description will appear, usually within half a second, to guide you on their specific purpose.
