# 6. YAML as configuration file

Date: 2018-06-30

## Status

Accepted

## Context

In order to use a custom ADR template, it must be possible to configure the path to it. The same template must be used so that all ADR`s are structured in the same way.

## Decision

The template path can be defined via a [YAML](http://yaml.org/) configuration file.

## Consequences

We need to add [symfony/yaml](https://github.com/symfony/yaml) as a dependency to the project.

To have a single place of truth the "directory" option must be removed from all console commands, because the directory can be defined in the configuration file.