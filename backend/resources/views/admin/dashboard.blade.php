<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <style>
    body{font-family:Inter,system-ui,sans-serif;margin:0;background:#f8fafc;color:#0f172a}
    .container{max-width:1100px;margin:auto;padding:24px}
    .nav{display:flex;gap:16px;margin-bottom:20px;flex-wrap:wrap}
    .grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:16px}
    .card{background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:16px}
    table{width:100%;border-collapse:collapse} th,td{padding:10px;border-bottom:1px solid #e2e8f0;text-align:left}
  </style>
</head>
<body>
<div class="container">
  <div class="nav">
    <strong>Stock Commerce Admin</strong>
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    <a href="{{ route('admin.products.index') }}">Products</a>
    <a href="{{ route('admin.managers.index') }}">Shop Managers</a>
    <a href="{{ route('admin.pos.index') }}">POS</a>
  </div>

  <div class="grid">
    <div class="card"><h3>Total Products</h3><p>{{ $totalProducts }}</p></div>
    <div class="card"><h3>Total Categories</h3><p>{{ $totalCategories }}</p></div>
    <div class="card"><h3>Total Orders</h3><p>{{ $totalOrders }}</p></div>
    <div class="card"><h3>Revenue</h3><p>${{ number_format($revenue, 2) }}</p></div>
    <div class="card"><h3>Shop Managers</h3><p>{{ $totalManagers }}</p></div>
  </div>

  <div class="card" style="margin-top:16px;">
    <h3>Recent Orders</h3>
    <table>
      <thead><tr><th>ID</th><th>Manager</th><th>Email</th><th>Status</th><th>Total</th></tr></thead>
      <tbody>
      @forelse($recentOrders as $order)
      <tr>
        <td>#{{ $order->id }}</td>
        <td>{{ $order->manager?->name ?? 'Online' }}</td>
        <td>{{ $order->email }}</td>
        <td>{{ $order->status }}</td>
        <td>${{ number_format($order->total_amount, 2) }}</td>
      </tr>
      @empty
      <tr><td colspan="5">No orders yet.</td></tr>
      @endforelse
      </tbody>
    </table>
  </div>

  <div class="card" style="margin-top:16px;">
    <h3>Low Stock Alert</h3>
    <table>
      <thead><tr><th>Product</th><th>Inventory</th></tr></thead>
      <tbody>
      @forelse($lowStockProducts as $product)
      <tr>
        <td>{{ $product->name }}</td>
        <td>{{ $product->inventory }}</td>
      </tr>
      @empty
      <tr><td colspan="2">No low stock product.</td></tr>
      @endforelse
      </tbody>
    </table>
  </div>
</div>
</body>
</html>
