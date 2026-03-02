<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Shop Managers</title>
  <style>
    body{font-family:Inter,system-ui,sans-serif;margin:0;background:#f8fafc;color:#0f172a}
    .container{max-width:1100px;margin:auto;padding:24px}
    .card{background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:16px;margin-bottom:16px}
    .grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:12px}
    input,select{width:100%;padding:8px;border:1px solid #cbd5e1;border-radius:8px}
    button{padding:8px 12px;border:none;border-radius:8px;background:#0f172a;color:#fff;cursor:pointer}
    table{width:100%;border-collapse:collapse} th,td{padding:10px;border-bottom:1px solid #e2e8f0;text-align:left}
  </style>
</head>
<body>
<div class="container">
  <p>
    <a href="{{ route('admin.dashboard') }}">Dashboard</a> |
    <a href="{{ route('admin.products.index') }}">Products</a> |
    <a href="{{ route('admin.pos.index') }}">POS</a>
  </p>

  @if(session('status'))
    <div class="card">{{ session('status') }}</div>
  @endif

  <div class="card">
    <h3>Add Shop Manager</h3>
    <form method="POST" action="{{ route('admin.managers.store') }}">
      @csrf
      <div class="grid">
        <div><label>Name</label><input name="name" required></div>
        <div><label>Email</label><input type="email" name="email" required></div>
        <div><label>Phone</label><input name="phone"></div>
      </div>
      <div style="margin-top:12px;"><button type="submit">Create Manager</button></div>
    </form>
  </div>

  <div class="card">
    <h3>Manager List</h3>
    <table>
      <thead><tr><th>Name</th><th>Email</th><th>Phone</th><th>Status</th><th>Update</th></tr></thead>
      <tbody>
      @forelse($managers as $manager)
      <tr>
        <td>{{ $manager->name }}</td>
        <td>{{ $manager->email }}</td>
        <td>{{ $manager->phone ?: '-' }}</td>
        <td>{{ $manager->is_active ? 'Active' : 'Inactive' }}</td>
        <td>
          <form method="POST" action="{{ route('admin.managers.update', $manager) }}">
            @csrf
            @method('PATCH')
            <select name="is_active">
              <option value="1" @selected($manager->is_active)>Active</option>
              <option value="0" @selected(!$manager->is_active)>Inactive</option>
            </select>
            <button type="submit" style="margin-top:6px;">Save</button>
          </form>
        </td>
      </tr>
      @empty
      <tr><td colspan="5">No shop manager found.</td></tr>
      @endforelse
      </tbody>
    </table>
    <div style="margin-top:12px;">{{ $managers->links() }}</div>
  </div>
</div>
</body>
</html>
