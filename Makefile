ci:
	vendor/bin/phpunit tests
	vendor/bin/ecs check --config vendor/landingi/php-coding-standards/ecs.php
	vendor/bin/phpstan analyse -c phpstan.neon
fix:
	vendor/bin/ecs check --fix --config vendor/landingi/php-coding-standards/ecs.php
run:
	composer install --no-interaction --prefer-dist
	exec /usr/bin/supervisord -c /etc/supervisor/supervisord.conf
