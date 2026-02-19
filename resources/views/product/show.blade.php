{{-- resources/views/products/show.blade.php --}}
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Especificaciones | Producto</title>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
@php
  // SHOW: 1 SOLO producto (ideal: viene desde controlador)
  $product = $product ?? [
    'id_producto'=>'P-1001',
    'nombre'=>'Audífonos Nova',
    'precio'=>189900,
    'descripcion'=>'Audífonos inalámbricos con cancelación de ruido, batería prolongada y micrófonos para llamadas.',
    'imagen'=>'https://picsum.photos/seed/nova/1400/900',
    'estado'=>'Disponible',
  ];

  $e=strtolower($product['estado']);
  $badge = $e==='disponible' ? 'badge--ok' : ($e==='agotado' ? 'badge--warn' : 'badge--bad');
@endphp

<header class="topbar">
  <div class="container topbar__inner">
    <a class="brand" href="{{ url('/products') }}"><span>🛍️</span><strong>StoreUI</strong></a>
    <nav class="nav">
      <a href="{{ url('/products') }}">Catálogo</a>
      <a href="{{ url('/products/create') }}">Crear</a>
      <a class="active" href="#">Especificaciones</a>
    </nav>
    <button class="btn btn--ghost" id="themeBtn" type="button">🌙</button>
  </div>
</header>

<main>
  <div class="container">
    <section class="hero">
      <h1>Especificaciones (SHOW)</h1>
      <p>Esta vista NO lista productos. Solo muestra la ficha del producto seleccionado.</p>
      <div class="muted" style="margin-top:8px">
        <a href="{{ url('/products') }}">Catálogo</a> › {{ $product['id_producto'] }}
      </div>
    </section>

    <img class="showImage" src="{{ $product['imagen'] }}" alt="Imagen del producto {{ $product['nombre'] }}">

    <div class="spacer"></div>

    <section class="card pad">
      <div style="display:flex;gap:10px;flex-wrap:wrap;align-items:center;justify-content:space-between;">
        <div>
          <h2 style="margin:0 0 6px">{{ $product['nombre'] }}</h2>
          <div style="display:flex;gap:8px;flex-wrap:wrap;align-items:center;">
            <span class="badge {{ $badge }}">● {{ $product['estado'] }}</span>
            <span class="badge">ID: {{ $product['id_producto'] }}</span>
          </div>
        </div>
        <div style="text-align:right">
          <div class="muted" style="font-size:13px">Precio</div>
          <div style="font-size:28px;font-weight:1000">$ {{ number_format($product['precio'],0,',','.') }}</div>
        </div>
      </div>

      <div class="hr"></div>

      {{-- SOLO ESPECIFICACIONES DEL PRODUCTO --}}
      <div class="specGrid">
        <div class="specItem"><div class="k">id_producto</div><div class="v">{{ $product['id_producto'] }}</div></div>
        <div class="specItem"><div class="k">nombre</div><div class="v">{{ $product['nombre'] }}</div></div>
        <div class="specItem"><div class="k">precio</div><div class="v">$ {{ number_format($product['precio'],0,',','.') }}</div></div>
        <div class="specItem"><div class="k">estado</div><div class="v">{{ $product['estado'] }}</div></div>

        <div class="specItem" style="grid-column:1/-1">
          <div class="k">descripcion</div>
          <div class="v" style="font-weight:700;color:var(--muted)">{{ $product['descripcion'] }}</div>
        </div>

        <div class="specItem" style="grid-column:1/-1">
          <div class="k">imagen</div>
          <div class="v" style="font-weight:700;color:var(--muted)">{{ $product['imagen'] }}</div>
        </div>
      </div>

      <div class="spacer"></div>

      <div style="display:flex;gap:10px;flex-wrap:wrap;justify-content:flex-end;">
        <a class="btn btn--ghost" href="{{ url('/products') }}">← Volver al catálogo</a>
        <button class="btn" id="copyBtn" type="button">Copiar ID</button>
      </div>
    </section>
  </div>
</main>

<footer>
  <div class="container fgrid">
    <div><strong>StoreUI</strong><div class="muted">SHOW: ficha de 1 producto</div></div>
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

  // Copiar ID
  document.getElementById('copyBtn').addEventListener('click', async ()=>{
    try{ await navigator.clipboard.writeText(@json($product['id_producto'])); toast('ID copiado ✅'); }
    catch(e){ toast('No se pudo copiar ❌'); }
  });

  function toast(msg){
    const t=document.createElement('div'); t.className='toast'; t.textContent=msg;
    document.body.appendChild(t); requestAnimationFrame(()=>t.classList.add('on'));
    setTimeout(()=>t.classList.remove('on'),2200); setTimeout(()=>t.remove(),2600);
  }
</script>
</body>
</html>
