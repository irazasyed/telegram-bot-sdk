# Change Log
All notable changes to this project will be documented in this file.
This project adheres to [Semantic Versioning](http://semver.org/).

## [Unreleased][unreleased]
### Added
- New `sendVoice()` method as per API Changes - Thanks @jonnywilliamson - PR[#19](https://github.com/irazasyed/telegram-bot-sdk/pull/19).
- Branch Alias to Composer to install `dev-master` easily.
- Commands System: Automated Inbound Commands Handler.
- Commands Handler Support for Laravel.
- Command Bus Methods to Super Class.
- Default Help Command.
- Chat Actions Helper Class.
- CHANGELOG File.
- Magic Methods Documentation for Commands Class - Thanks @jonnywilliamson - PR[#26](https://github.com/irazasyed/telegram-bot-sdk/pull/26).
- Telegram Bot SDK [API Docs](https://irazasyed.github.io/telegram-bot-sdk/api).

### Changed
- `uploadFile()` method to support loading resource directly - Thanks @rkhitin - PR[#17](https://github.com/irazasyed/telegram-bot-sdk/pull/17).
- Added optional `performer` and `title` fields to `sendAudio()` as per official API Changes - Thanks @jonnywilliamson - PR[#19](https://github.com/irazasyed/telegram-bot-sdk/pull/19) - **[BC]**.
- Added `certificate` param to `setWebhook()` method as per Official API Changes.
- Refactor Upload File Method.
- Format Code, Simplify FQNs, Code Cleanup and Revise Doc Blocks.
- Revise Token Exception Text.
- Clean Up Base Object Class.
- Rename Namespace from `Irazasyed\Telegram` to `Telegram\Bot` - **[BC]**.
- Rename [Telegram.php](https://github.com/irazasyed/telegram-bot-sdk/blob/v0.2.6/src/Telegram.php) - `Irazasyed\Telegram\Telegram` to [Api.php](https://github.com/irazasyed/telegram-bot-sdk/blob/master/src/Api.php) - `Telegram\Bot\Api` - **[BC]**.

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
- Invalid resource type issue [#6](https://github.com/irazasyed/telegram-bot-sdk/issues/6).

### Removed
- KeyboardMarkup Class Import Statement.

## [0.2.2] - 2015-07-02
### Fixed
- `Irazasyed\Telegram\Exceptions\TelegramSDKException` not found issue [#4](https://github.com/irazasyed/telegram-bot-sdk/issues/4).

## [0.2.1] - 2015-07-02
### Added
- `recentMessage()` to Update object class.

### Changed
- Make `$token` param optional in constructor - Thanks @orloffv issue [#1](https://github.com/irazasyed/telegram-bot-sdk/issues/1).

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

[unreleased]: https://github.com/irazasyed/telegram-bot-sdk/compare/v0.2.6...HEAD
[0.2.6]: https://github.com/irazasyed/telegram-bot-sdk/compare/v0.2.5...v0.2.6
[0.2.5]: https://github.com/irazasyed/telegram-bot-sdk/compare/v0.2.4...v0.2.5
[0.2.4]: https://github.com/irazasyed/telegram-bot-sdk/compare/v0.2.3...v0.2.4
[0.2.3]: https://github.com/irazasyed/telegram-bot-sdk/compare/v0.2.2...v0.2.3
[0.2.2]: https://github.com/irazasyed/telegram-bot-sdk/compare/v0.2.1...v0.2.2
[0.2.1]: https://github.com/irazasyed/telegram-bot-sdk/compare/v0.2.0...v0.2.1
[0.2.0]: https://github.com/irazasyed/telegram-bot-sdk/compare/v0.1.0...v0.2.0