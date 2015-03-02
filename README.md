Voxbone Provisioning API Library (PHP)
=================

How To Configure:
=================
The generated code might need to be configured with your API credentials. To do that,
provide the credentials and configuration values as a constructor parameters for the controllers. This can be done in the following manner (see index.php):

`````

$controller = new OrderingController(Configuration::$BasicAuthUserName, Configuration::$BasicAuthPassword);

`````

Additionally you need to add your credentials in the Configuration.php file:

``````

  public static $BasicAuthUserName = "username";
  public static $BasicAuthPassword = "password";

``````

How To Build:
=============
The generated code uses a PHP library namely UniRest. The reference to this
library is already added as a composer dependency in the generated composer.json
file. Therefore, you will need internet access to resolve this dependency.

How To Use:
===========
For using this SDK do the following:

    1. Open a new PHP >= 5.3 project and copy the generated PHP files in the project
       directory.
    2. Use composer (https://getcomposer.org/) to install the dependencies. Usually this can be done through a
       context menu command "php composer.phar install".
    3. Include the ProvisioningAPILib.php file in your code where
       needed using "require_once" construct.
    4. You can now instantiate controllers and call the respective methods.
    5. cdrs.php, inventory.php, ordering.php, configuration.php, and regulation.php contain sample code that uses this library.

Contributing:
============

If you find issues or have any improvements for the library, please don't hesitate to commit and send a note to developers@voxbone.com to explain what you tried to achieve.


