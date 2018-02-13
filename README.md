# ADR Tools in PHP

A PHP based command-line interface tool for working with ADR ([Architecture Decision Records](http://thinkrelevance.com/blog/2011/11/15/documenting-architecture-decisions)).

## Requirements

Requires PHP version 7.1.3 or newer

##  Installation

You can install this tool using the [Composer](https://getcomposer.org/), execute the following command.

```
composer require globtec/phpadr --dev dev-master
```

## Usage

After of install this project you may execute the binary `phpadr` in your terminal:

```
./vendor/bin/phpadr
```

To view a list of all avaliable PHPADR commands, you may use the `list` command:

```
./vendor/bin/phpadr list
```

To create a new ADR, you may use the `make:decision` command:

```
./vendor/bin/phpadr make:decision <title> [<status="Accepted">] [--directory="docs/arch"]
```

To count the ADRs, you may use the `workspace:count` command:

```
./vendor/bin/phpadr workspace:count [--directory="docs/arch"]
```

To list the ADRs, you may use the `workspace:list` command:

```
./vendor/bin/phpadr workspace:list [--directory="docs/arch"]
```

For more help execute the following command:

```
./vendor/bin/phpadr <command> --help
```