#!/bin/sh

rm -rf app/Resources/views/client
mkdir app/Resources/views/client
cp client/production/index.html app/Resources/views/client/index.html.twig
cp -R client/assets/* web/