{{-- resources/views/products/index.blade.php --}}
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Catálogo | Productos</title>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
@php
  // INDEX: 5 productos - SOLO info básica (catálogo)
  $products = $products ?? [
    ['id_producto'=>'P-1001','nombre'=>'Audífonos Nova','precio'=>189900,'imagen'=>'https://picsum.photos/seed/nova/900/600','estado'=>'Disponible'],
    ['id_producto'=>'P-1002','nombre'=>'Teclado Pulse','precio'=>299900,'imagen'=>'https://picsum.photos/seed/pulse/900/600','estado'=>'Disponible'],
    ['id_producto'=>'P-1003','nombre'=>'Mouse Flow','precio'=>119900,'imagen'=>'https://picsum.photos/seed/flow/900/600','estado'=>'Agotado'],
    ['id_producto'=>'P-1004','nombre'=>'Monitor UltraView 27”','precio'=>899900,'imagen'=>'https://picsum.photos/seed/ultraview/900/600','estado'=>'Disponible'],
    ['id_producto'=>'P-1005','nombre'=>'Webcam StreamPro','precio'=>159900,'imagen'=>'https://picsum.photos/seed/streampro/900/600','estado'=>'Inactivo'],
  ];
@endphp

<header class="topbar">
  <div class="container topbar__inner">
    <a class="brand" href="{{ url('/products') }}"><span>🛍️</span><strong>StoreUI</strong></a>
    <nav class="nav">
      <a class="active" href="{{ url('/products') }}">Catálogo</a>
      <a href="{{ url('/products/create') }}">Crear</a>
    </nav>
    <button class="btn btn--ghost" id="themeBtn" type="button">🌙</button>
  </div>
</header>

<main>
  <div class="container">
    <section class="hero">
      <h1>Catálogo (INDEX)</h1>
      <p>Aquí se muestran 5 productos en lista. No hay especificaciones aquí.</p>
    </section>

    <section class="catalogGrid">
      @foreach($products as $p)
        @php
          $e = strtolower($p['estado']);
          $badge = $e==='disponible' ? 'badge--ok' : ($e==='agotado' ? 'badge--warn' : 'badge--bad');
        @endphp

        <article class="card catalogCard">
          <img src="{{ $p['imagen'] }}" alt="Imagen {{ $p['nombre'] }}" loading="lazy">
          <div class="catalogBody">
            <h3 class="catalogTitle">{{ $p['nombre'] }}</h3>

            <div class="catalogMeta">
              <span class="badge {{ $badge }}">● {{ $p['estado'] }}</span>
              <span class="badge">ID: {{ $p['id_producto'] }}</span>
            </div>

            <div style="display:flex;justify-content:space-between;align-items:baseline;gap:10px">
              <div class="price">$ {{ number_format($p['precio'],0,',','.') }}</div>
              <span class="muted" style="font-size:13px">★ ★ ★ ★ ☆</span>
            </div>

            <div class="catalogActions">
              {{-- Va al SHOW (especificación de 1 producto) --}}
              <a class="btn btn--primary" href="{{ url('/products/'.$p['id_producto']) }}">Ver</a>
              <button class="btn btn--ghost" type="button" onclick="toast('Favorito: {{ addslashes($p['nombre']) }}')">♡</button>
            </div>
          </div>
        </article>
      @endforeach
    </section>
  </div>
</main>

<footer>
  <div class="container fgrid">
    <div><strong>StoreUI</strong><div class="muted">INDEX: catálogo</div></div>
    <div><h4 style="margin:6px 0 8px;font-size:14px">Links</h4><ul class="flinks"><li><a href="{{ url('/products') }}">Catálogo</a></li><li><a href="{{ url('/products/create') }}">Crear</a></li></ul></div>
    <div><h4 style="margin:6px 0 8px;font-size:14px">Ayuda</h4><ul class="flinks"><li><a href="#">Soporte</a></li><li><a href="#">Políticas</a></li></ul></div>
    <small class="muted">© {{ date('Y') }} StoreUI</small>
  </div>
</footer>

<script>
  // Tema
  const root=document.documentElement, themeBtn=document.getElementById('themeBtn');
  const saved=localStorage.getItem('theme'); if(saved) root.dataset.theme=saved;
  themeBtn.textContent = root.dataset.theme==='light' ? '🌙' : '☀️';
  themeBtn.onclick=()=>{const n=root.dataset.theme==='light'?'dark':'light';root.dataset.theme=n;localStorage.setItem('theme',n);themeBtn.textContent=n==='light'?'🌙':'☀️';};

  // Toast
  function toast(msg){
    const t=document.createElement('div'); t.className='toast'; t.textContent=msg;
    document.body.appendChild(t); requestAnimationFrame(()=>t.classList.add('on'));
    setTimeout(()=>t.classList.remove('on'),2200); setTimeout(()=>t.remove(),2600);
  }
</script>
</body>
</html>
