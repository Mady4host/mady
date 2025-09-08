using Domain.Shared.Entities;
using Infrastructure.Data;
using Microsoft.EntityFrameworkCore;

namespace Infrastructure.Data;

public static class DataSeeder
{
    public static async Task SeedAsync(ApplicationDbContext context)
    {
        // Ensure database is created
        await context.Database.EnsureCreatedAsync();

        // Check if data already exists
        if (await context.Categories.AnyAsync())
            return;

        // Seed Categories
        var categories = new List<Category>
        {
            new Category { Name = "Mobile Phones", Description = "Smartphones and mobile devices" },
            new Category { Name = "Mobile Accessories", Description = "Cases, chargers, and accessories" },
            new Category { Name = "Computers", Description = "Laptops, desktops, and computer hardware" },
            new Category { Name = "Computer Accessories", Description = "Keyboards, mice, monitors, etc." }
        };

        await context.Categories.AddRangeAsync(categories);
        await context.SaveChangesAsync();

        // Seed Products
        var products = new List<Product>();
        var random = new Random();

        // Mobile Phones
        for (int i = 1; i <= 20; i++)
        {
            products.Add(new Product
            {
                Name = $"Smartphone Model {i}",
                Description = $"High-quality smartphone with advanced features {i}",
                Price = random.Next(200, 1500),
                Stock = random.Next(5, 50),
                Barcode = $"SMT{i:D6}",
                CategoryId = categories[0].Id
            });
        }

        // Mobile Accessories
        for (int i = 1; i <= 15; i++)
        {
            products.Add(new Product
            {
                Name = $"Mobile Accessory {i}",
                Description = $"Essential mobile accessory item {i}",
                Price = random.Next(10, 100),
                Stock = random.Next(10, 100),
                Barcode = $"ACC{i:D6}",
                CategoryId = categories[1].Id
            });
        }

        // Computers
        for (int i = 1; i <= 10; i++)
        {
            products.Add(new Product
            {
                Name = $"Computer System {i}",
                Description = $"Professional computer system {i}",
                Price = random.Next(500, 2500),
                Stock = random.Next(2, 20),
                Barcode = $"CMP{i:D6}",
                CategoryId = categories[2].Id
            });
        }

        // Computer Accessories
        for (int i = 1; i <= 15; i++)
        {
            products.Add(new Product
            {
                Name = $"Computer Accessory {i}",
                Description = $"Professional computer accessory {i}",
                Price = random.Next(15, 200),
                Stock = random.Next(5, 75),
                Barcode = $"CPA{i:D6}",
                CategoryId = categories[3].Id
            });
        }

        await context.Products.AddRangeAsync(products);
        await context.SaveChangesAsync();
    }
}