# ADR Tools in PHP

[![Build Status](https://travis-ci.org/globtec/phpadr.svg?branch=master)](https://travis-ci.org/globtec/phpadr)
[![Coverage Status](https://coveralls.io/repos/github/globtec/phpadr/badge.svg?branch=master)](https://coveralls.io/github/globtec/phpadr?branch=master)

A PHP based command-line interface tool for working with Architecture Decision Records (ADR).

## About ADR

Architecture Decision Records (ADR) is a technique for capturing important architectural decisions, along with their context and consequences as described by [Michael Nygard](https://twitter.com/mtnygard) in his article: [Documenting Architecture Decisions](http://thinkrelevance.com/blog/2011/11/15/documenting-architecture-decisions).

## Requirements

* Requires PHP version 7.1.3 or newer
* Multibyte String extension

##  Installation

You can install this tool using the [Composer](https://getcomposer.org/), execute the following command.

```
composer require globtec/phpadr --dev
```

## Usage

After of install this project you may execute the binary `phpadr` in your terminal:

```
./vendor/bin/phpadr
```

If to execute the command above, it will be showd a list of all avaliable tool commands.

By default the records will be stored in `docs/arch`, to change this workspace use the option `--config` with the path of the config file.

### Create a new ADR

You may use the `make:decision` command:

```
./vendor/bin/phpadr make:decision <title> [<status="Accepted">] [--config="adr.yml"]
```

### Count the ADRs

You may use the `workspace:count` command:

```
./vendor/bin/phpadr workspace:count [--config="adr.yml"]
```

### List the ADRs

You may use the `workspace:list` command:

```
./vendor/bin/phpadr workspace:list [--config="adr.yml"]
```

### Help

For more help execute the following command:

```
./vendor/bin/phpadr <command> --help
```