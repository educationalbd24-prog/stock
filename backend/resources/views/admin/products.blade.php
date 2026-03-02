<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Products</title>
  <style>
    body{font-family:Inter,system-ui,sans-serif;margin:0;background:#f8fafc;color:#0f172a}
    .container{max-width:1200px;margin:auto;padding:24px}
    .card{background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:16px;margin-bottom:16px}
    .grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:12px}
    input,select,textarea{width:100%;padding:8px;border:1px solid #cbd5e1;border-radius:8px}
    button{padding:8px 12px;border:none;border-radius:8px;background:#0f172a;color:#fff;cursor:pointer}
    table{width:100%;border-collapse:collapse} th,td{padding:10px;border-bottom:1px solid #e2e8f0;text-align:left}
  </style>
</head>
<body>
<div class="container">
  <p>
    <a href="{{ route('admin.dashboard') }}">Dashboard</a> |
    <a href="{{ route('admin.managers.index') }}">Shop Managers</a> |
    <a href="{{ route('admin.pos.index') }}">POS</a>
  </p>

  @if(session('status'))
    <div class="card">{{ session('status') }}</div>
  @endif

  <div class="card">
    <h3>Add Product</h3>
    <form method="POST" action="{{ route('admin.products.store') }}">
      @csrf
      <div class="grid">
        <div><label>Name</label><input name="name" required></div>
        <div>
          <label>Category</label>
          <select name="category_id" required>
            @foreach($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
          </select>
        </div>
        <div><label>Price</label><input type="number" step="0.01" name="price" required></div>
        <div><label>Inventory</label><input type="number" name="inventory" required></div>
        <div style="grid-column: span 2;"><label>Image URL</label><input type="url" name="image_url" required></div>
      </div>
      <div style="margin-top:12px;"><label>Description</label><textarea name="description" rows="3" required></textarea></div>
      <div style="margin-top:12px;"><button type="submit">Create Product</button></div>
    </form>
  </div>

  <div class="card">
    <h3>Existing Products</h3>
    <table>
      <thead><tr><th>Name</th><th>Category</th><th>Price</th><th>Stock</th><th>Actions</th></tr></thead>
      <tbody>
      @forelse($products as $product)
        <tr>
          <td>{{ $product->name }}</td>
          <td>{{ $product->category->name }}</td>
          <td>${{ number_format($product->price, 2) }}</td>
          <td>{{ $product->inventory }}</td>
          <td>
            <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Delete this product?')">
              @csrf
              @method('DELETE')
              <button type="submit">Delete</button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="5">No products found.</td></tr>
      @endforelse
      </tbody>
    </table>
    <div style="margin-top:12px;">{{ $products->links() }}</div>
  </div>
</div>
</body>
</html>
