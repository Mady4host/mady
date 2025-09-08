# Mobile & Accessories Shop ERP/POS

Lightweight, offline-first desktop system for multi-branch mobile/computer accessories shops with POS, inventory, repairs, accounting, barcode/receipt printing, and Egypt payment/recharge integrations.

## Tech Stack (Recommended)
- Desktop: .NET 8 + WPF/WinUI 3
- API (optional for multi-branch/sync): ASP.NET Core
- DB: PostgreSQL (central), SQLite (local offline cache)
- ORM: EF Core
- Background jobs: Hangfire/Quartz
- Logging: Serilog
- Reports/Invoices: FastReport/Stimulsoft + ESC/POS (thermal) + ZPL (labels)
- Barcode: ZXing.Net (read), raw ESC/POS/ZPL (print)
- Licensing: RSA-based key, device binding, periodic verification

## Core Modules
- Auth & Licensing, Branches & RBAC
- Inventory & Categories (Mobile, Mobile Accessories, Computer, extensible)
- Purchases (PO, GRN), Suppliers
- Sales (Retail & Wholesale), Returns, Cash drawer & Shifts
- Repairs (Mobile/Desktop/Laptop workflow)
- Accounting basics & P/L reports
- Stocktaking, Damage/Spoilage
- Recharge (Vodafone/Orange/Etisalat/WE via provider), Cards
- Wallets: Vodafone Cash, InstaPay (send/receive) + reconciliation
- Settings: taxes, printers, invoice/label design, providers

## Architecture
- Desktop app works offline with SQLite; syncs to central API (PostgreSQL) using outbox/inbox pattern.
- Plugin interfaces for payments/recharge to swap providers without core changes.
- Fast, direct printing using ESC/POS and ZPL.

## Folder Structure (proposed)
- src/
  - Client.Desktop/ (WPF/WinUI)
  - Server.Api/ (ASP.NET Core)
  - Domain.Shared/
  - Infrastructure/
  - Modules/
    - Inventory/
    - Sales/
    - Purchases/
    - Repairs/
    - Accounting/
    - Integrations/
- docs/
  - requirements.md
  - data-model.mmd
  - api-contract.md
- .github/workflows/ci.yml

## Next
- Confirm stack and modules scope.
- Implement Auth/RBAC + Inventory + POS (retail) + Receipts + Licensing (MVP).
- Add Repairs + Wholesale + Cash drawer/shifts.
- Integrations for recharge/wallets with one provider first.
