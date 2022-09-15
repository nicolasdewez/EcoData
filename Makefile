SHELL = /bin/bash
.DEFAULT_GOAL := help

##
## Code quality
## ------------
coding-standard: ## Validate coding standards
#### path -> path to a file, or a folder.
	@./vendor/bin/php-cs-fixer fix --using-cache=no --dry-run --verbose --show-progress=estimating --allow-risky=yes -- $(path)

fix-coding-standard: ## Fix coding standards
#### path -> path to a file, or a folder.
	@./vendor/bin/php-cs-fixer fix --allow-risky=yes -- $(path)

code-analysis: ## Run a static analysis
#### path -> path to a file, or a folder (default: src).
#### level -> phpstan analysis level.
	$(eval level ?= 6)
	$(eval path ?= src)
	$(eval format ?= table)
	@./vendor/bin/phpstan analyse -c phpstan.neon --level $(level) --error-format $(format) $(path)

clear-code-analysis-cache: ## Remove the result cache to debug custom rules
	@./vendor/bin/phpstan clear-result-cache

.PHONY: coding-standard fix-coding-standard code-analysis clear-code-analysis-cache

##
## Tools
## -----

deep-clear: cc cl ## Clear caches and logs

cc: ## Clear cache (symfony & behat)
	@$(DC_WEB) sh -c 'rm -rf -- var/cache/* /tmp/behat* && echo "\033[1;32mCache cleared\033[m"'

cl: ## Clear logs (symfony)
	@$(DC_WEB) sh -c 'rm -rf -- var/logs/* && echo "\033[1;32mLogs cleared\033[m"'

##
## Help
## ----
help: Makefile ## Show this help
#### section -> section to display.
ifdef section
	$(eval options = --section '$(section)')
endif
	php tools/makefile.help.php -f $< $(settings) $(options)

help-verbose: settings = -v
help-verbose: help ## Show this help with the rule options
#### section -> section to display.

.PHONY: help help-verbose

%:
	@:
