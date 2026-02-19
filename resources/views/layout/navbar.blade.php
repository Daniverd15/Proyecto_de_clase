<header class="topbar">
  <div class="container topbar__inner">
    <a class="brand" href="{{ url('/products') }}"><span>🛍️</span><strong>StoreUI</strong></a>
    <nav class="nav">
      <a href="{{ url('/products') }}">Catálogo</a>
      <a class="active" href="{{ url('/products/create') }}">Crear</a>
    </nav>
    <button class="btn btn--ghost" id="themeBtn" type="button">🌙</button>
  </div>
</header>
