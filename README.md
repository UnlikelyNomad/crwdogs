# crwdogs

To setup once cloned:

1. Install composer
Linux: wget -O - http://getcomposer.org/installer | php

2. Install dependencies with composer
php composer.phar install

3. Copy propel.sample.yml to propel.yml and fill in database info

4. Generate php config file
vender/bin/propel config:convert

5. Copy crwdogs/mail.config.sample.php to crwdogs/mail.config.php and fill in oauth credentials