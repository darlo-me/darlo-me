CP=cp -a
PHP=php
MKDIR=mkdir

SRC    = src/pub
DEST   = build

######## FILES ########

ALL_FILES  := $(shell rg --files -L $(SRC)/ -g "!$(SRC)/dist/*")

DIST_FILES := $(@shell rg --files -L $(SRC)/dist)
DIST_OBJ   := $(patsubst $(SRC)/%,$(DEST)/%,$(DIST_FILES))

PHP_FILES  := $(filter %.php, $(ALL_FILES))
PHP_OBJ    := $(patsubst $(SRC)/%.php,$(DEST)/%,$(PHP_FILES))

OTHER_FILES := $(filter-out $(PHP_FILES),$(ALL_FILES))
OTHER_OBJ   := $(patsubst $(SRC)/%,$(DEST)/%,$(OTHER_FILES))

ALL_OBJ   := $(PHP_OBJ) $(DIST_OBJ) $(OTHER_OBJ)

DIFF_OBJ := $(filter-out $(ALL_OBJ),$(shell find $(DEST) -type f -not -path '$(DEST)/.git/*'))
DIFF_FOLDERS := $(dir $(DIFF_OBJ))

.DELETE_ON_ERROR: 
.PHONY: all push clean

all: push

# https://github.com/tschaub/gh-pages/issues/213
push: $(DEST)
	cd build && \
	echo 'darlo.me' > CNAME && \
	git init && \
	git add -A && \
	{ git commit -m "build" || true; } && \
	git push -f --set-upstream https://github.com/darlo-me/darlo-me-static master

clean:
	rm -rf $(DEST)

FORCE:

# we want to remove files than don't exist anymore
ifeq ($(DIFF_OBJ),)
$(DEST): $(ALL_OBJ)
else
$(DEST): $(ALL_OBJ) FORCE
	rm -- $(DIFF_OBJ)
	@for i in $(DIFF_FOLDERS); do if [ -z "$$(ls -A "$$i")" ]; then rmdir -v -- "$$i"; fi; done
endif

# rebuild everything everytime
# the reason we add FORCE is because PHP_FILES does not contain private/included PHP files
$(PHP_OBJ): $(DEST)/%: $(SRC)/%.php $(PHP_FILES) FORCE
	@$(MKDIR) -p $(@D)
	php $< > $@

$(OTHER_OBJ): $(DEST)/%: $(SRC)/%
	@$(MKDIR) -p $(@D)
	$(CP) $< $@

$(DIST_OBJ): $(DEST)/%: $(SRC)/%
	@$(MKDIR) -p $(@D)
	$(CP) $< $@
