# 4. Composer as dependency management

Date: 2018-02-13

## Status

Accepted

## Context

Managing dependencies manually in any programming language is hard work, then we will need to use a dependency management tool for that project.

## Decision

It will be used the [Composer](https://getcomposer.org/) as tool for dependency management.

This project can also be installed with Composer using the following command:

```
composer require globtec/phpadr --dev dev-master
```

## Consequences

You must have the Composer tool installed.

The Composer allows you to declare the libraries your projects depends on and it will manage (install/update) them for you.