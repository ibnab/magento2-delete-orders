#Magento 2 delete orders extension from Ibnab

More infos visit our magento 2 blog post: http://ibnab.com/en/blog/magento-2/magento-2-extension-our-new-extension-delete-orders

##Manual installation :
download from github
past in your folder app/code
enable extension in  app/etc/config.php by adding 'Ibnab_DeleteOrder' => 1,
and execute the command php bin/magento setup:upgrade

##Install with Composer!

    composer require ibnab/magento2-delete-orders:1.0.0

Then you'll need to modify 'app/etc/config.php' to activate the module. It should look a little like this:

    <?php
    return array (
        'modules' =>
        array (
            ...
            'Ibnab_DeleteOrders' => 1,
            ),
          );
