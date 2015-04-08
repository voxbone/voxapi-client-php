Voxbone Provisioning API Library (PHP)
=================

The Provisioning API enables Voxbone customers to automate the ordering and configuration of phone numbers and channels.

How To Configure:
=================
The generated code might need to be configured with your API credentials. To do that,
provide the credentials and configuration values as a constructor parameters for the controllers. This can be done in the following manner (see ordering.php):

`````

Unirest::auth(Configuration::$BasicAuthUserName, Configuration::$BasicAuthPassword);

`````

Additionally you need to add your credentials in the Configuration.php file:

``````

  public static $BasicAuthUserName = "your_username";
  public static $BasicAuthPassword = "you_password";

``````

How To Build:
=============
The generated code uses a PHP library namely UniRest. The reference to this
library is already added as a composer dependency in the generated composer.json
file. Therefore, you will need internet access to resolve this dependency.

For using this SDK do the following:

    1. Open a new PHP >= 5.3 project and copy the generated PHP files in the project
       directory.
    2. Use composer (https://getcomposer.org/) to install the dependencies. Usually this can be done through a
       context menu command "php composer.phar install".
    3. You can now instantiate controllers and call the respective methods.
    4. cdrs.php, inventory.php, ordering.php, configuration.php, and regulation.php contain sample code that uses this library.

Contributing:
============

If you find issues or have any improvements for the library, please don't hesitate to commit or open an issue.

