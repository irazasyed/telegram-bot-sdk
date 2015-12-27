# Change Log
All notable changes to this project will be documented in this file.
This project adheres to [Semantic Versioning](http://semver.org/).

## [2.0.0] - 2015-12-28
### Added
- More doc blocks to the code.
- New `getFile()` method & File Object - Thanks @jonnywilliamson ([#39](https://github.com/irazasyed/telegram-bot-sdk/pull/39)).
- Channel Username Support.
- Dependency Injection in Commands - Thanks @antoniomadonna ([#53](https://github.com/irazasyed/telegram-bot-sdk/pull/53)).
- PHPUnit Tests - Thanks @antoniomadonna ([#58](https://github.com/irazasyed/telegram-bot-sdk/pull/58)).
- Travis Config.
- PHPUnit 4.8 Version to Support PHP5.5 Testing.
- Git Attributes File.
- Composer Config & Other Options.
- Composer script test to make it easier to run phpunit by firing `composer test`.
- Nitpick Config.
- New `removeCommand()` & `removeCommands()` methods to the API & their Tests - Thanks @jonnywilliamson ([#66](https://github.com/irazasyed/telegram-bot-sdk/pull/66)).
- New Remote Files Upload Support - ([#42](https://github.com/irazasyed/telegram-bot-sdk/issues/42)).
- Laravel 5.2 Support.
- New Message Object Properties - Thanks @jonnywilliamson ([#75](https://github.com/irazasyed/telegram-bot-sdk/pull/75)).
- More PHPUnit Tests & Mocking 'Telegram Response' class - Thanks @jonnywilliamson ([#76](https://github.com/irazasyed/telegram-bot-sdk/pull/76)).
- Added ability to change request timeout and connection timeout globally for all Telegram API requests - Thanks @ihoru ([#81](https://github.com/irazasyed/telegram-bot-sdk/pull/81)).

### Changed
- Methods' Params to Array, To support constant changes by Telegram - ([#54](https://github.com/irazasyed/telegram-bot-sdk/issues/54)) **[BC]**.
- Revise Doc Blocks.
- Update Commands Class to Reflect Param Changes.
- Update Help Command.
- Refactor Command Magic Method Arguments.
- Refactor Laravel Service Provider to Support DI.
- Message Detecting methods to support Message object too - Thanks @jonnywilliamson ([#37](https://github.com/irazasyed/telegram-bot-sdk/pull/37)).
- Switch to POST requests method to make API requests - Thanks @jonnywilliamson ([#40](https://github.com/irazasyed/telegram-bot-sdk/pull/40)).
- Update Chat field change to new Chat Object in place of GroupChat Object - Thanks @jonnywilliamson ([#46](https://github.com/irazasyed/telegram-bot-sdk/pull/46)).
- Improve `mapRelatives` to initialize inner properties - Thanks @alexsoft ([#49](https://github.com/irazasyed/telegram-bot-sdk/pull/49)).
- Tests Namespace.
- Tests to Autoload in Dev.
- PHPUnit Tests Config.
- Applied Scrutinizer's Best Practises & Other Fixes.
- CS Fixes & Doc Block Updates - Thanks @jonnywilliamson ([#72](https://github.com/irazasyed/telegram-bot-sdk/pull/72)).
- Get Updates & Process command enhancements to prevent errors - Thanks @autowp ([#85](https://github.com/irazasyed/telegram-bot-sdk/pull/85)) & ([#88](https://github.com/irazasyed/telegram-bot-sdk/pull/88)).
- Library Documentation Rewritten for V2 - Thanks @jonnywilliamson ([#89](https://github.com/irazasyed/telegram-bot-sdk/pull/89)).

### Fixed
- `ReplyWith` Params Bug.
- `uploadFile` Bug Opening Webhook URL.

### Removed
- Group Chat Object.

## [1.0.0] - 2015-09-08
### Added
- New `sendVoice()` method as per API Changes - Thanks @jonnywilliamson ([#19](https://github.com/irazasyed/telegram-bot-sdk/pull/19)).
- Branch Alias to Composer to install `dev-master` easily.
- Commands System: Automated Inbound Commands Handler.
- Commands Handler Support for Laravel.
- Command Bus Methods to Super Class.
- Default Help Command.
- Chat Actions Helper Class.
- CHANGELOG File.
- Magic Methods Documentation for Commands Class and Object Classes - Thanks @jonnywilliamson ([#26](https://github.com/irazasyed/telegram-bot-sdk/pull/26)).
- API Object Classes Magic Method PHPDocs - Thanks @jonnywilliamson ([#30](https://github.com/irazasyed/telegram-bot-sdk/pull/30)).
- New Documentation Page.
- Telegram Bot SDK [API Docs](https://irazasyed.github.io/telegram-bot-sdk/api).
- [Upgrade](upgrade.md) Guide.
- Methods to Detect and Determine Message/Update Type.

### Changed
- `uploadFile()` method to support loading resource directly - Thanks @rkhitin - ([#17](https://github.com/irazasyed/telegram-bot-sdk/pull/17)).
- Added optional `performer` and `title` fields to `sendAudio()` as per official API Changes - Thanks @jonnywilliamson ([#19](https://github.com/irazasyed/telegram-bot-sdk/pull/19)) - **[BC]**.
- Added `certificate` param to `setWebhook()` method as per Official API Changes.
- Refactor Upload File Method.
- Format Code, Simplify FQNs, Code Cleanup and Revise Doc Blocks.
- Revise Token Exception Text.
- Clean Up Base Object Class.
- Rename Namespace from `Irazasyed\Telegram` to `Telegram\Bot` - **[BC]**.
- Rename [Telegram.php](https://github.com/irazasyed/telegram-bot-sdk/blob/v0.2.6/src/Telegram.php) - `Irazasyed\Telegram\Telegram` to [Api.php](https://github.com/irazasyed/telegram-bot-sdk/blob/master/src/Api.php) - `Telegram\Bot\Api` - **[BC]**.
- Move PHPDocs to its own home.
- Revise README.

## [0.2.6] - 2015-08-18
### Added
- Video Caption Support to `sendVideo()` method as per Official API Changes - Thanks @jonnywilliamson.
- Duration Support to `sendVideo()` and `sendAudio()` methods as per Official API Changes.

### Fixed
- Contact Object Namespace - Thanks @DmitryNek
- `HTTPClientHandlerInterface` Laravel Config Typo.

## [0.2.5] - 2015-07-20
### Fixed
- Custom HTTP Client Handler Not Found - Thanks @codengine.

### Removed
- `getLastName()` example from README.

## [0.2.4] - 2015-07-12
### Added
- Installation Requirements in README.

### Changed
- Laravel Service Provider.
- Revise README.

### Removed
- Laravel 4 Support.

## [0.2.3] - 2015-07-12
### Added
- Message Object Relatives.

### Changed
- `ReplyMarkupKeyboard` Example in README.
- Composer Keywords.
- Profile Links in README.

### Fixed
- Invalid resource type issue ([#6](https://github.com/irazasyed/telegram-bot-sdk/issues/6)).

### Removed
- KeyboardMarkup Class Import Statement.

## [0.2.2] - 2015-07-02
### Fixed
- `Irazasyed\Telegram\Exceptions\TelegramSDKException` not found issue ([#4](https://github.com/irazasyed/telegram-bot-sdk/issues/4)).

## [0.2.1] - 2015-07-02
### Added
- `recentMessage()` to Update object class.

### Changed
- Make `$token` param optional in constructor - Thanks @orloffv issue ([#1](https://github.com/irazasyed/telegram-bot-sdk/issues/1)).

## [0.2.0] - 2015-07-02
### Added
- `getWebhookUpdates()` method.
- Documentation in README for `getWebhookUpdates()` method.
- Contributing Guidelines.
- Disclaimer and Note to README.
- Banner Image in README.
- Link back to Telegram Bot API Page.

### Changed
- Refactor `getUpdates()` method.
- Project LICENSE.
- Revise README.

## 0.1.0 - 2015-06-29
- Initial Release.

[unreleased]: https://github.com/irazasyed/telegram-bot-sdk/compare/v2.0.0...HEAD
[2.0.0]: https://github.com/irazasyed/telegram-bot-sdk/compare/v1.0.0...v2.0.0
[1.0.0]: https://github.com/irazasyed/telegram-bot-sdk/compare/v0.2.6...v1.0.0
[0.2.6]: https://github.com/irazasyed/telegram-bot-sdk/compare/v0.2.5...v0.2.6
[0.2.5]: https://github.com/irazasyed/telegram-bot-sdk/compare/v0.2.4...v0.2.5
[0.2.4]: https://github.com/irazasyed/telegram-bot-sdk/compare/v0.2.3...v0.2.4
[0.2.3]: https://github.com/irazasyed/telegram-bot-sdk/compare/v0.2.2...v0.2.3
[0.2.2]: https://github.com/irazasyed/telegram-bot-sdk/compare/v0.2.1...v0.2.2
[0.2.1]: https://github.com/irazasyed/telegram-bot-sdk/compare/v0.2.0...v0.2.1
[0.2.0]: https://github.com/irazasyed/telegram-bot-sdk/compare/v0.1.0...v0.2.0
