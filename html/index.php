<pre>
<?php
echo 'DOMAIN: '.$_SERVER['SERVER_NAME'].PHP_EOL;
echo 'CREDENTIAL: '.getenv('CREDENTIAL').PHP_EOL;
echo 'WEB_ROOT: '.getenv('WEB_ROOT').PHP_EOL;
?>
</pre>

<?php
phpinfo();