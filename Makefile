PHP_SETUP = -d memory_limit=2G -dxdebug.max_nesting_level=10000
DXDEBUG_SETUP = -dxdebug.start_with_request=yes -dxdebug.mode=debug

RUN_PHP = php ${PHP_SETUP} ${DXDEBUG_SETUP}

prepare:
	php ${PHP_SETUP} ./run.php prepare ${DAY} ${YEAR}

debug:
	$(RUN_PHP) ./run.php test ${DAY} ${YEAR}

test:
	php ${PHP_SETUP} ./run.php test ${DAY} ${YEAR}

send:
	php ${PHP_SETUP} ./run.php send ${DAY} ${YEAR}