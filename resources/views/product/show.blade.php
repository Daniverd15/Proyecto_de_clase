{{-- resources/views/products/show.blade.php --}}
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Detalle del producto | StoreUI</title>

  <style>
    :root{
      --bg:#0b0e14; --card:#101726; --text:#e9eefc; --muted:rgba(233,238,252,.72);
      --border:rgba(255,255,255,.11); --shadow:0 18px 45px rgba(0,0,0,.35);
      --brand:#ff7a18; --brand2:#af002d; --ok:#2bd576; --warn:#ffd166; --bad:#ff4d4d;
      --r:18px; --r2:26px;
    }
    [data-theme="light"]{
      --bg:#f6f7fb; --card:#ffffff; --text:#0b1020; --muted:rgba(11,16,32,.64);
      --border:rgba(11,16,32,.12); --shadow:0 16px 40px rgba(20,30,60,.16);
    }
    *{box-sizing:border-box}
    body{
      margin:0; font-family:system-ui,-apple-system,Segoe UI,Roboto,Arial;
      background:
        radial-gradient(900px 500px at 15% -10%, rgba(255,122,24,.25), transparent 60%),
        radial-gradient(800px 500px at 90% 10%, rgba(175,0,45,.20), transparent 55%),
        var(--bg);
      color:var(--text);
    }
    a{color:inherit;text-decoration:none}
    .container{width:min(1150px,92vw);margin:0 auto}
    .muted{color:var(--muted)}

    .btn{
      display:inline-flex;align-items:center;justify-content:center;gap:8px;
      padding:11px 14px;border-radius:14px;border:1px solid var(--border);
      background:var(--card);color:var(--text);cursor:pointer;
      transition:transform .12s ease, box-shadow .12s ease, background .12s ease;
    }
    .btn:hover{transform:translateY(-1px);box-shadow:var(--shadow)}
    .btn--primary{border-color:transparent;background:linear-gradient(135deg,var(--brand),var(--brand2))}
    .btn--ghost{background:transparent}

    .badge{
      display:inline-flex;align-items:center;gap:6px;
      padding:7px 10px;border-radius:999px;border:1px solid var(--border);
      color:var(--muted);font-size:13px;background:color-mix(in oklab, var(--card) 86%, transparent);
    }
    .badge--ok{border-color:color-mix(in oklab,var(--ok) 55%, var(--border));color:color-mix(in oklab,var(--ok) 78%, var(--text))}
    .badge--warn{border-color:color-mix(in oklab,var(--warn) 55%, var(--border));color:color-mix(in oklab,var(--warn) 80%, var(--text))}
    .badge--bad{border-color:color-mix(in oklab,var(--bad) 55%, var(--border));color:color-mix(in oklab,var(--bad) 80%, var(--text))}

    /* Topbar (misma en las 3 vistas) */
    .topbar{
      position:sticky;top:0;z-index:1000;backdrop-filter:blur(12px);
      background:color-mix(in oklab,var(--bg) 76%, transparent);
      border-bottom:1px solid var(--border);
    }
    .topbar__inner{display:flex;align-items:center;justify-content:space-between;gap:14px;padding:12px 0}
    .brand{
      display:flex;align-items:center;gap:10px;padding:10px 12px;border-radius:999px;
      border:1px solid var(--border);
      background:color-mix(in oklab,var(--card) 80%, transparent);
      box-shadow:0 8px 24px rgba(0,0,0,.18);
    }
    .brand__logo{font-size:18px}
    .nav{display:flex;gap:6px;flex-wrap:wrap}
    .nav a{padding:10px 12px;border-radius:999px;border:1px solid transparent;color:var(--muted)}
    .nav a:hover{color:var(--text);border-color:var(--border);background:color-mix(in oklab,var(--card) 75%, transparent)}
    .nav .active{
      color:var(--text);
      border-color:color-mix(in oklab,var(--brand) 60%, var(--border));
      background:linear-gradient(135deg,
        color-mix(in oklab,var(--brand) 25%, transparent),
        color-mix(in oklab,var(--brand2) 20%, transparent));
    }
    .actions{display:flex;align-items:center;gap:10px}
    .search{position:relative;width:min(340px,46vw)}
    .search input{
      width:100%;padding:11px 40px 11px 14px;border-radius:999px;border:1px solid var(--border);
      background:color-mix(in oklab,var(--card) 85%, transparent);color:var(--text);outline:none;
    }
    .search .icon{position:absolute;right:12px;top:50%;transform:translateY(-50%);opacity:.75}
    @media (max-width:520px){.nav{display:none}.search{width:55vw}}

    main{padding:22px 0 46px}
    .hero{
      padding:18px 18px 16px;border-radius:var(--r2);border:1px solid var(--border);
      background:linear-gradient(135deg,
        color-mix(in oklab,var(--brand) 26%, transparent),
        color-mix(in oklab,var(--brand2) 18%, transparent));
      margin-bottom:14px;
    }
    .hero h1{margin:0 0 6px;font-size:clamp(22px,3vw,34px)}
    .hero p{margin:0;color:var(--muted);line-height:1.4}

    .grid{display:grid;grid-template-columns:repeat(12,1fr);gap:14px}
    .span-8{grid-column:span 8}
    .span-4{grid-column:span 4}
    @media (max-width:900px){.span-8,.span-4{grid-column:span 12}.search{width:min(340px,60vw)}}

    .card{
      border:1px solid var(--border);border-radius:var(--r2);
      background:color-mix(in oklab,var(--card) 92%, transparent);
      box-shadow:0 10px 30px rgba(0,0,0,.18);
    }
    .pad{padding:16px}

    .cover{width:100%;height:320px;object-fit:cover;display:block;filter:saturate(1.08) contrast(1.02)}
    .body{padding:14px}
    .meta{display:flex;gap:8px;flex-wrap:wrap;align-items:center;margin:8px 0 10px}
    .price{font-size:26px;font-weight:950}
    .desc{line-height:1.6;margin-top:10px}

    .panel__row{display:flex;justify-content:space-between;gap:10px;padding:10px 0;border-bottom:1px dashed var(--border)}
    .panel__row:last-child{border-bottom:none}

    /* Footer (misma en las 3 vistas) */
    footer{
      border-top:1px solid var(--border);padding:22px 0;
      background:color-mix(in oklab,var(--bg) 80%, transparent);
    }
    .fgrid{display:grid;grid-template-columns:1.3fr 1fr 1fr;gap:14px}
    .fgrid small{grid-column:1/-1}
    .flinks{list-style:none;padding:0;margin:0;display:grid;gap:6px}
    .flinks a{color:var(--muted)}
    .flinks a:hover{color:var(--text);text-decoration:underline}
    @media (max-width:900px){.fgrid{grid-template-columns:1fr}}
  </style>
</head>

<body>
@php
  // Si no llega $product desde controlador, usamos demo:
  $product = $product ?? [
    'id_producto' => 'P-1001',
    'nombre' => 'Audífonos Inalámbricos Nova',
    'precio' => 189900,
    'descripcion' => 'Cancelación de ruido, estuche de carga, 24h de batería. Sonido balanceado y diseño ligero para uso diario.',
    'imagen' => 'https://picsum.photos/seed/nova/1400/900',
    'estado' => 'Disponible'
  ];
  $e = strtolower($product['estado']);
  $badge = $e==='disponible' ? 'badge--ok' : ($e==='agotado' ? 'badge--warn' : 'badge--bad');
@endphp

<header class="topbar">
  <div class="container topbar__inner">
    <a class="brand" href="/products">
      <span class="brand__logo">🛍️</span>
      <span><strong>Store</strong><span class="muted">UI</span></span>
    </a>

    <nav class="nav">
      <a href="/products">Productos</a>
      <a href="/products/create">Crear</a>
      <a class="active" href="#">Show</a>
    </nav>

    <div class="actions">
      <div class="search">
        <input type="search" placeholder="Buscar (demo)..." autocomplete="off">
        <span class="icon">⌕</span>
      </div>
      <button class="btn btn--ghost" id="themeBtn" type="button" title="Cambiar tema">🌙</button>
    </div>
  </div>
</header>

<main>
  <div class="container">
    <section class="hero">
      <h1>{{ $product['nombre'] }}</h1>
      <p>Vista detalle del producto · ID: <strong>{{ $product['id_producto'] }}</strong></p>
    </section>

    <div class="grid">
      <section class="span-8">
        <article class="card" style="overflow:hidden">
          <img class="cover" src="{{ $product['imagen'] }}" alt="Imagen de {{ $product['nombre'] }}">
          <div class="body">
            <div class="meta">
              <span class="badge {{ $badge }}">● {{ $product['estado'] }}</span>
              <span class="badge">ID: {{ $product['id_producto'] }}</span>
              <span class="badge">★ ★ ★ ★ ☆</span>
            </div>

            <div class="price">$ {{ number_format($product['precio'],0,',','.') }}</div>
            <p class="desc muted">{{ $product['descripcion'] }}</p>

            <div class="card pad" style="margin-top:14px">
              <h3 style="margin:0 0 6px">Características (demo)</h3>
              <ul class="muted" style="margin:0;padding-left:18px;line-height:1.6">
                <li>Diseño moderno y compacto</li>
                <li>Materiales resistentes</li>
                <li>Garantía 12 meses (ejemplo)</li>
                <li>Calidad optimizada para uso diario</li>
              </ul>
            </div>

            <div style="display:flex;gap:10px;flex-wrap:wrap;justify-content:space-between;margin-top:14px">
              <a class="btn btn--ghost" href="/products">← Volver</a>
              <div style="display:flex;gap:10px;flex-wrap:wrap">
                <button class="btn" type="button" id="copyBtn">Copiar ID</button>
                <button class="btn btn--primary" type="button" onclick="alert('Compra simulada ✅')">Comprar</button>
              </div>
            </div>
          </div>
        </article>
      </section>

      <aside class="span-4">
        <div class="card pad">
          <h3 style="margin:0 0 6px">Ficha rápida</h3>
          <div class="panel__row"><span class="muted">ID</span><strong>{{ $product['id_producto'] }}</strong></div>
          <div class="panel__row"><span class="muted">Estado</span><strong>{{ $product['estado'] }}</strong></div>
          <div class="panel__row"><span class="muted">Precio</span><strong>$ {{ number_format($product['precio'],0,',','.') }}</strong></div>

          <div style="display:grid;gap:10px;margin-top:12px">
            <a class="btn btn--primary" href="/products/create">Crear otro</a>
            <button class="btn" type="button" onclick="alert('Compartir (demo) ✅')">Compartir</button>
          </div>
        </div>

        <div class="card pad" style="margin-top:14px">
          <h4 style="margin:0 0 6px">Recomendado</h4>
          <p class="muted" style="margin:0">Productos similares aparecerían aquí (demo).</p>
          <div style="margin-top:10px" class="badge badge--ok">🔥 Tendencia</div>
        </div>
      </aside>
    </div>
  </div>
</main>

<footer>
  <div class="container fgrid">
    <div>
      <div style="display:flex;align-items:center;gap:10px">
        <span style="font-size:18px">🧡</span><strong>StoreUI</strong>
      </div>
      <p class="muted" style="margin:8px 0 0">Vista Show con detalle y panel lateral.</p>
    </div>

    <div>
      <h4 style="margin:6px 0 8px;font-size:14px">Secciones</h4>
      <ul class="flinks">
        <li><a href="/products">Productos</a></li>
        <li><a href="/products/create">Crear</a></li>
      </ul>
    </div>

    <div>
      <h4 style="margin:6px 0 8px;font-size:14px">Soporte</h4>
      <ul class="flinks">
        <li><a href="#">Documentación</a></li>
        <li><a href="#">Ayuda</a></li>
        <li><a href="#">Políticas</a></li>
      </ul>
    </div>

    <small class="muted">© {{ date('Y') }} StoreUI · Blade + CSS</small>
  </div>
</footer>

<script>
  // Tema
  const root = document.documentElement;
  const themeBtn = document.getElementById('themeBtn');
  const saved = localStorage.getItem('theme');
  if(saved) root.dataset.theme = saved;
  themeBtn.textContent = root.dataset.theme === 'light' ? '🌙' : '☀️';
  themeBtn.addEventListener('click', ()=>{
    const next = root.dataset.theme === 'light' ? 'dark' : 'light';
    root.dataset.theme = next;
    localStorage.setItem('theme', next);
    themeBtn.textContent = next === 'light' ? '🌙' : '☀️';
  });

  // Copiar ID
  document.getElementById('copyBtn').addEventListener('click', async ()=>{
    try{
      await navigator.clipboard.writeText(@json($product['id_producto']));
      alert('ID copiado ✅');
    }catch(e){
      alert('No se pudo copiar (tu navegador lo bloqueó).');
    }
  });
</script>
</body>
</html>
