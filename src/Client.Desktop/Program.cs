using System.Net.Http.Json;
using System.Text.Json;

namespace Client.Desktop;

// Simulating localization resources
public static class LocalizationService
{
    private static bool _isArabic = true; // Default to Arabic (RTL)
    
    public static bool IsArabic => _isArabic;
    
    public static void ToggleLanguage()
    {
        _isArabic = !_isArabic;
        Console.WriteLine($"Language switched to: {(_isArabic ? "Arabic (RTL)" : "English (LTR)")}");
    }
    
    public static string GetString(string key)
    {
        var arabicResources = new Dictionary<string, string>
        {
            {"AppTitle", "متجر موبايل وإكسسوارات"},
            {"Login", "تسجيل الدخول"},
            {"Username", "اسم المستخدم"},
            {"Password", "كلمة المرور"},
            {"Welcome", "مرحباً"},
            {"Products", "المنتجات"},
            {"Categories", "الفئات"},
            {"Language", "اللغة"},
            {"MainWindow", "النافذة الرئيسية"},
            {"LoggedIn", "تم تسجيل الدخول بنجاح"},
            {"FetchingProducts", "جاري تحميل المنتجات..."},
            {"Exit", "خروج"}
        };
        
        var englishResources = new Dictionary<string, string>
        {
            {"AppTitle", "Mobile & Accessories Shop"},
            {"Login", "Login"},
            {"Username", "Username"},
            {"Password", "Password"},
            {"Welcome", "Welcome"},
            {"Products", "Products"},
            {"Categories", "Categories"},
            {"Language", "Language"},
            {"MainWindow", "Main Window"},
            {"LoggedIn", "Logged in successfully"},
            {"FetchingProducts", "Fetching products..."},
            {"Exit", "Exit"}
        };
        
        var resources = _isArabic ? arabicResources : englishResources;
        return resources.TryGetValue(key, out var value) ? value : key;
    }
}

// Simple Product model for client
public class Product
{
    public int Id { get; set; }
    public string Name { get; set; } = string.Empty;
    public string? Description { get; set; }
    public decimal Price { get; set; }
    public int Stock { get; set; }
    public string? Barcode { get; set; }
    public int CategoryId { get; set; }
}

// Main application class
public class Program
{
    private static readonly HttpClient httpClient = new();
    private static readonly string ApiBaseUrl = "http://localhost:5080";
    private static bool isLoggedIn = false;
    
    public static async Task Main(string[] args)
    {
        Console.OutputEncoding = System.Text.Encoding.UTF8;
        
        // Display app title in current language
        Console.WriteLine($"=== {LocalizationService.GetString("AppTitle")} ===");
        Console.WriteLine();
        
        // Simple login simulation
        LoginAsync();
        
        if (isLoggedIn)
        {
            await MainWindowAsync();
        }
    }
    
    private static void LoginAsync()
    {
        Console.WriteLine($"{LocalizationService.GetString("Login")}:");
        Console.WriteLine();
        
        Console.Write($"{LocalizationService.GetString("Username")}: ");
        var username = Console.ReadLine();
        
        Console.Write($"{LocalizationService.GetString("Password")}: ");
        var password = Console.ReadLine();
        
        // Simple authentication simulation
        if (!string.IsNullOrEmpty(username) && !string.IsNullOrEmpty(password))
        {
            Console.WriteLine($"{LocalizationService.GetString("LoggedIn")}!");
            Console.WriteLine($"{LocalizationService.GetString("Welcome")}, {username}!");
            isLoggedIn = true;
        }
        else
        {
            Console.WriteLine("Login failed. Please try again.");
        }
        
        Console.WriteLine();
    }
    
    private static async Task MainWindowAsync()
    {
        while (true)
        {
            Console.WriteLine($"=== {LocalizationService.GetString("MainWindow")} ===");
            Console.WriteLine($"1. {LocalizationService.GetString("Products")}");
            Console.WriteLine($"2. {LocalizationService.GetString("Categories")}");
            Console.WriteLine($"3. {LocalizationService.GetString("Language")} Toggle");
            Console.WriteLine($"4. {LocalizationService.GetString("Exit")}");
            Console.WriteLine();
            Console.Write("Choose an option: ");
            
            var choice = Console.ReadLine();
            
            switch (choice)
            {
                case "1":
                    await ShowProductsAsync();
                    break;
                case "2":
                    await ShowCategoriesAsync();
                    break;
                case "3":
                    LocalizationService.ToggleLanguage();
                    break;
                case "4":
                    return;
                default:
                    Console.WriteLine("Invalid option. Please try again.");
                    break;
            }
            
            Console.WriteLine();
        }
    }
    
    private static async Task ShowProductsAsync()
    {
        try
        {
            Console.WriteLine($"{LocalizationService.GetString("FetchingProducts")}");
            
            var response = await httpClient.GetAsync($"{ApiBaseUrl}/api/products");
            if (response.IsSuccessStatusCode)
            {
                var json = await response.Content.ReadAsStringAsync();
                var products = JsonSerializer.Deserialize<Product[]>(json, new JsonSerializerOptions
                {
                    PropertyNameCaseInsensitive = true
                });
                
                Console.WriteLine($"\n=== {LocalizationService.GetString("Products")} ===");
                
                if (products != null)
                {
                    var displayProducts = products.Take(10); // Show first 10 for console display
                    foreach (var product in displayProducts)
                    {
                        var direction = LocalizationService.IsArabic ? "RL" : "LR";
                        Console.WriteLine($"[{direction}] {product.Id}: {product.Name} - ${product.Price} (Stock: {product.Stock})");
                    }
                    
                    Console.WriteLine($"\nTotal products fetched: {products.Length}");
                }
            }
            else
            {
                Console.WriteLine($"Error fetching products: {response.StatusCode}");
            }
        }
        catch (Exception ex)
        {
            Console.WriteLine($"Error: {ex.Message}");
        }
    }
    
    private static async Task ShowCategoriesAsync()
    {
        try
        {
            var response = await httpClient.GetAsync($"{ApiBaseUrl}/api/categories");
            if (response.IsSuccessStatusCode)
            {
                var json = await response.Content.ReadAsStringAsync();
                using var doc = JsonDocument.Parse(json);
                
                Console.WriteLine($"\n=== {LocalizationService.GetString("Categories")} ===");
                
                foreach (var category in doc.RootElement.EnumerateArray())
                {
                    var id = category.GetProperty("id").GetInt32();
                    var name = category.GetProperty("name").GetString();
                    var description = category.GetProperty("description").GetString();
                    
                    var direction = LocalizationService.IsArabic ? "RL" : "LR";
                    Console.WriteLine($"[{direction}] {id}: {name} - {description}");
                }
            }
            else
            {
                Console.WriteLine($"Error fetching categories: {response.StatusCode}");
            }
        }
        catch (Exception ex)
        {
            Console.WriteLine($"Error: {ex.Message}");
        }
    }
}
