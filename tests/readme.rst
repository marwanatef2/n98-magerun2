**************
Test Framework
**************

We deliver a test framework for robusta-magerun2 commands.

=============
Configuration
=============

Set the environment variable `Robusta_MAGERUN2_TEST_MAGENTO_ROOT` with a path to a magento installation
which can be used to run tests.

i.e.

export Robusta_MAGERUN2_TEST_MAGENTO_ROOT=/home/myinstallation

=========
Run Tests
=========

You need PHPUnit to run the tests.
If you don't have PHPUnit installed on your system you can use the following command to install all test tools
at once.

..code-block:: sh

   composer.phar --dev install

Run PHPUnit in robusta-magerun2 root folder.
If you have installed with composer you can run::

   vendor/bin/phpunit
