# Changelog

All notable changes to this project will be documented in this file.

## 1.0.0 - 2026-11-16

First release: LGPD records of processing activities (art. 37) and DPO contact (art. 41).

- `ProcessingActivity`: purpose, legal basis, data subjects, recipients (processor/controller/public authority), international transfers (art. 33 mechanism), retention, security measures
- Activities link to `lgpd.models`: their `#[PersonalData]` columns join the record
- `php artisan lgpd:ropa [--json]` and `LgpdRecords::export()`: controller, DPO and every activity
- `<x-lgpd-records::dpo />`: public contact of the encarregado (name, mailto, tel)

## [Unreleased]
