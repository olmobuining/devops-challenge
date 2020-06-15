start:
	docker run -it --rm --name vf-script -v $$(pwd)/php/src:/usr/src/vf -w /usr/src/vf php:7.4-cli php start.php

test:
	docker run -it --rm --name vf-script -v $$(pwd)/php/src:/usr/src/vf -w /usr/src/vf php:7.4-cli php vendor/bin/phpunit tests