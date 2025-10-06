using Infrastructure.Data;
using Microsoft.EntityFrameworkCore;
using Domain.Shared.Entities;

var builder = WebApplication.CreateBuilder(args);

// Add services to the container.
builder.Services.AddEndpointsApiExplorer();
builder.Services.AddSwaggerGen();

// Add health checks
builder.Services.AddHealthChecks();

// Add Entity Framework
builder.Services.AddDbContext<ApplicationDbContext>(options =>
    options.UseSqlite(builder.Configuration.GetConnectionString("DefaultConnection") 
        ?? "Data Source=mady.db"));

// Configure JSON serialization to handle circular references
builder.Services.Configure<Microsoft.AspNetCore.Http.Json.JsonOptions>(options =>
{
    options.SerializerOptions.ReferenceHandler = System.Text.Json.Serialization.ReferenceHandler.IgnoreCycles;
});

// Add CORS for local development
builder.Services.AddCors(options =>
{
    options.AddDefaultPolicy(policy =>
    {
        policy.AllowAnyOrigin()
              .AllowAnyMethod()
              .AllowAnyHeader();
    });
});

var app = builder.Build();

// Configure the HTTP request pipeline.
if (app.Environment.IsDevelopment())
{
    app.UseSwagger();
    app.UseSwaggerUI();
}

app.UseCors();

// Health check endpoint
app.MapHealthChecks("/health");

// Ensure database is created and seeded
using (var scope = app.Services.CreateScope())
{
    var context = scope.ServiceProvider.GetRequiredService<ApplicationDbContext>();
    await DataSeeder.SeedAsync(context);
}

// API endpoints
app.MapGet("/api/products", async (ApplicationDbContext context, int page = 1, int pageSize = 50) =>
{
    var skip = (page - 1) * pageSize;
    var products = await context.Products
        .Include(p => p.Category)
        .OrderBy(p => p.Id)
        .Skip(skip)
        .Take(pageSize)
        .ToListAsync();
    
    return Results.Ok(products);
})
.WithName("GetProducts")
.WithOpenApi();

app.MapGet("/api/categories", async (ApplicationDbContext context) =>
{
    var categories = await context.Categories
        .OrderBy(c => c.Name)
        .ToListAsync();
    
    return Results.Ok(categories);
})
.WithName("GetCategories")
.WithOpenApi();

// Configure URLs
app.Urls.Add("http://localhost:5080");

app.Run();
