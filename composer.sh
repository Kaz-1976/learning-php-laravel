#!/bin/bash
podman run --rm -it -v .\src:/app composer $@
