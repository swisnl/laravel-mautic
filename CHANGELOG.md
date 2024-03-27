# Changelog

All notable changes to `swisnl/laravel-mautic` will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## [Unreleased]

* Nothing yet.


## [0.3.0] - 2024-03-27

### Added

* Added support for Laravel 11.

### Removed

* Removed support for Laravel 9.


## [0.2.0] - 2023-07-17

### Added

* Added support for Laravel 10.

### Changed

* Removed `withHttpClient` method in authenticator classes, use constructor instead.
* Internal OAuth client now uses the PSR-18 client provided by the `HttpClientFactory`.

### Fixed

* Throw NotificationException when notification fails.
