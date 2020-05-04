CP=cp -a
PHP=php

SRC    = src
DEST   = build

######## FILES ########

ALL_FILES  := $(shell rg --files -L $(SRC)/)

DIST_FILES := $(shell rg --files -L $(SRC)/dist)
PHP_FILES  := $(filter-out $(DIST_FILES),$(ALL_FILES))

DIST_OBJ   := $(patsubst $(SRC)/dist/%,$(DEST)/%,$(DIST_FILES))
PHP_OBJ    := $(patsubst $(SRC)/%.php,$(DEST)/%,$(PHP_FILES))

ALL_OBJ   := $(PHP_OBJ) $(DIST_OBJ)

.PHONY: all clean

all: $(DEST)
build: $(DEST)
clean:
	rm -rf $(DEST)

lint:
	$(ESLINT) $(SRC)

build: $(DEST)
$(DEST): $(ALL_OBJ)

$(PHP_OBJ): $(DEST)/%: $(SRC)/%
	@$(MKDIR) -p $(@D)
	php $< > $@

$(DIST_OBJ): $(DEST)/%: $(SRC)/dist/%
	@$(MKDIR) -p $(@D)
	$(CP) $< $@
