#!/bin/bash
docker run --rm -it -v .\src:/app composer $@
