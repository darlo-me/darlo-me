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

.PHONY: all clean

all: $(DEST)

clean:
	rm -rf $(DEST)

$(DEST): $(ALL_OBJ)

# rebuild everything everytime
$(PHP_OBJ): $(DEST)/%: $(SRC)/%.php $(PHP_FILES)
	@$(MKDIR) -p $(@D)
	php $< > $@

$(OTHER_OBJ): $(DEST)/%: $(SRC)/%
	@$(MKDIR) -p $(@D)
	$(CP) $< $@

$(DIST_OBJ): $(DEST)/%: $(SRC)/%
	@$(MKDIR) -p $(@D)
	$(CP) $< $@
