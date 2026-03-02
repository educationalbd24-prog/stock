<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>POS Checkout</title>
  <style>
    body{font-family:Inter,system-ui,sans-serif;margin:0;background:#f8fafc;color:#0f172a}
    .container{max-width:900px;margin:auto;padding:24px}
    .card{background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:16px;margin-bottom:16px}
    .row{display:grid;grid-template-columns:2fr 1fr;gap:12px}
    input,select{width:100%;padding:8px;border:1px solid #cbd5e1;border-radius:8px}
    button{padding:10px 14px;border:none;border-radius:8px;background:#0f172a;color:#fff;cursor:pointer}
  </style>
</head>
<body>
<div class="container">
  <p>
    <a href="{{ route('admin.dashboard') }}">Dashboard</a> |
    <a href="{{ route('admin.products.index') }}">Products</a> |
    <a href="{{ route('admin.managers.index') }}">Shop Managers</a>
  </p>

  @if(session('status'))
    <div class="card">{{ session('status') }}</div>
  @endif

  @if($errors->any())
    <div class="card" style="border-color:#ef4444;">
      @foreach($errors->all() as $error)
        <p style="color:#b91c1c;margin:0 0 6px;">{{ $error }}</p>
      @endforeach
    </div>
  @endif

  <div class="card">
    <h2>POS Checkout</h2>
    <p>শপ ম্যানেজার দিয়ে দ্রুত অর্ডার প্রসেস করতে এই ফর্ম ব্যবহার করুন।</p>

    <form method="POST" action="{{ route('admin.pos.checkout') }}">
      @csrf
      <div style="margin-bottom:10px;">
        <label>Shop Manager</label>
        <select name="manager_id" required>
          @foreach($managers as $manager)
          <option value="{{ $manager->id }}">{{ $manager->name }}</option>
          @endforeach
        </select>
      </div>

      <div style="margin-bottom:10px;">
        <label>Customer Email</label>
        <input type="email" name="email" required>
      </div>

      <h4>Items</h4>
      @for($i = 0; $i < 3; $i++)
      <div class="row" style="margin-bottom:10px;">
        <div>
          <label>Product</label>
          <select name="items[{{ $i }}][product_id]">
            <option value="">Select product</option>
            @foreach($products as $product)
            <option value="{{ $product->id }}">{{ $product->name }} (stock: {{ $product->inventory }})</option>
            @endforeach
          </select>
        </div>
        <div>
          <label>Qty</label>
          <input type="number" min="1" name="items[{{ $i }}][quantity]" value="1">
        </div>
      </div>
      @endfor

      <button type="submit">Complete POS Checkout</button>
    </form>
  </div>
</div>
</body>
</html>
