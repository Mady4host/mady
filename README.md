# Mady - Mobile & Accessories Shop ERP/POS

Complete .NET 8 solution for a mobile and accessories shop management system with offline-first desktop client and API backend.

## Features

### 🏪 Core Components
- **Client.Desktop**: Console application with RTL Arabic support and localization
- **Server.Api**: ASP.NET Core minimal API with SQLite database
- **Domain.Shared**: Product and Category entities
- **Infrastructure**: EF Core data layer with automatic seeding

### 🌐 API Endpoints
- `GET /health` - Health check endpoint
- `GET /api/products` - Get first 50 products with category information
- `GET /api/categories` - Get all product categories

### 🌍 Localization
- **Arabic (RTL)**: Default language with right-to-left support
- **English (LTR)**: Left-to-right language option
- Dynamic language switching via resource dictionaries

## Quick Start

### Prerequisites
- .NET 8.0 SDK or later
- Visual Studio Code (recommended) or Visual Studio

### Running the Solution

1. **Clone and build:**
   ```bash
   git clone https://github.com/Mady4host/mady.git
   cd mady
   dotnet build
   ```

2. **Start the API server:**
   ```bash
   cd src/Server.Api
   dotnet run
   ```
   API will be available at: http://localhost:5080

3. **Run the desktop client** (in a new terminal):
   ```bash
   cd src/Client.Desktop
   dotnet run
   ```

### Using VS Code
Open the project in VS Code and use the provided launch configurations:
- **F5**: Launch both API and Desktop applications
- **Ctrl+Shift+P** → "Tasks: Run Task" → Select task to run

## Project Structure

```
src/
├── Client.Desktop/          # Console app simulating WPF desktop client
│   ├── Resources/
│   │   ├── Lang.ar.xaml    # Arabic resources
│   │   └── Lang.en.xaml    # English resources
│   └── Program.cs          # Main application with localization
├── Server.Api/             # ASP.NET Core minimal API
│   ├── Program.cs          # API configuration and endpoints
│   └── appsettings.json    # Database connection settings
├── Domain.Shared/          # Core business entities
│   ├── Product.cs          # Product entity
│   └── Category.cs         # Category entity
└── Infrastructure/         # Data access layer
    ├── ApplicationDbContext.cs  # EF Core context
    └── DataSeeder.cs           # Database seeding
```

## Database

The application uses SQLite for local development with automatic:
- **Database creation** on first run
- **Data seeding** with 60 sample products across 4 categories:
  - Mobile Phones (20 products)
  - Mobile Accessories (15 products)
  - Computers (10 products)
  - Computer Accessories (15 products)

## Development

### Building
```bash
dotnet build
```

### Running Tests
```bash
dotnet test
```

### Publishing
```bash
# API
dotnet publish src/Server.Api -c Release -o publish/api

# Desktop
dotnet publish src/Client.Desktop -c Release -o publish/desktop
```

## Configuration Files
- `.editorconfig` - Code style and formatting
- `.gitignore` - Git ignore patterns
- `global.json` - .NET SDK version
- `.github/workflows/dotnet.yml` - CI/CD pipeline
- `.vscode/` - VS Code debugging and task configuration

## Next Steps
- Implement full WPF desktop application when Windows Desktop workload is available
- Add PostgreSQL support for production environments
- Implement user authentication and authorization
- Add more comprehensive inventory management features

## Tech Stack
- **.NET 8** - Runtime platform
- **ASP.NET Core** - Web API framework
- **Entity Framework Core** - ORM
- **SQLite** - Local database
- **Console Application** - Desktop client (WPF simulation)
- **GitHub Actions** - CI/CD