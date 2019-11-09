# bkscms-admin-panel

> A bkstar123/bkscms's package adding an admin panel (with authentication & authorization features) for a **BKSCMS** project  

For creating a **BKSCMS** project, run the following command:  
```composer create-project --prefer-dist bkstar123/bkscms <your-project>```  

## 1. Requirement
It is recommended to install this package with PHP version 7.1.3+ and Laravel Framework version 5.6+

## 2. Installation
    composer require bkstar123/bkscms-admin-panel

Then, publish the package's configuration file (you do not need to do it if you run ```php artian bkscms:install``` to install the **BKSCMS** project):    
```php artisan vendor:publish --provider=Bkstar123\BksCMS\AdminPanel\Providers\AdminPanelServiceProvider```  

## 3. Usage

The package offers an artisan command ```php artisan bkscms:initAuth --scope=<permissions|all>```  

All the following steps are not required if you run ```php artian bkscms:install``` to install the **BKSCMS** project.  
- Create database tables  
```php artisan migrate```  
- Seed data to ***roles, admins, permissions*** tables and do other arrangements  
```php artisan bkscms:initAuth --scope=all```  
- Create full-text index for ***roles, permissions, admins*** tables  
```php
php artisan mysql-search:init Bkstar123\BksCMS\AdminPanel\Admin
php artisan mysql-search:init Bkstar123\BksCMS\AdminPanel\Role
php artisan mysql-search:init Bkstar123\BksCMS\AdminPanel\Permission
```

It will create two users ***superadmin*** & ***administrator*** with passwords ***superadmin1@*** and ***administrator1@*** respectively. You can use these credentials to login and create your own users (you must assign ***superadmins*** role to at least one user). Finally, do not forget to remove/disable the default ***superadmin & administrator*** users for security reason before rolling out to production environment.  

Later, when you add more permissions to **permissions** key in **config/bkstar123_bkscms_adminpanel.php**, you can just run ```php artisan bkscms:initAuth --scope=permissions``` to re-initialize the permissions table  

**Note**  
The package provides ***bkscms-auth*** & ***bkscms-guest*** middleware to replace ***auth*** & ***guest*** respectively for all CMS routes (i.e under the path ***/cms/\****)  



