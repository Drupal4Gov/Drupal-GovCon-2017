#!/usr/bin/env bash

echo "running frontend setup for twentynineteen"
(cd docroot/themes/custom/twentynineteen;export PUPPETEER_SKIP_CHROMIUM_DOWNLOAD=true;npm run install-tools)
