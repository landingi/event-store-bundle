ci:
	./vendor/bin/phpunit tests --colors=always
	./vendor/bin/ecs check
fix:
	./vendor/bin/ecs check --fix
