#! /bin/bash
BASEDIR=$(dirname $0)
zip -r $BASEDIR/../../public/resources/wptool.zip $BASEDIR -x deploy.sh