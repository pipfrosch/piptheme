#!/bin/bash
find . -print |grep "\.po" |while read file; do
  echo ${file}
  BASE=${file%.po}
  echo $BASE
  MO="${BASE}.mo"
  echo ${MO}
  if [ -f ${MO} ]; then
    rm -f ${MO}
    msgfmt ${file} -o ${MO}
  fi
done
