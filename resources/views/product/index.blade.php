{{-- resources/views/products/index.blade.php --}}
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Productos | StoreUI</title>

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
      user-select:none;
    }
    .btn:hover{transform:translateY(-1px);box-shadow:var(--shadow)}
    .btn:active{transform:translateY(0);box-shadow:none}
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
    .search input:focus{border-color:color-mix(in oklab,var(--brand) 55%, var(--border));box-shadow:0 0 0 6px color-mix(in oklab,var(--brand) 20%, transparent)}
    .search .icon{position:absolute;right:12px;top:50%;transform:translateY(-50%);opacity:.75}

    /* Main */
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
    @media (max-width:520px){.nav{display:none}.search{width:55vw}}

    .card{
      border:1px solid var(--border);border-radius:var(--r2);
      background:color-mix(in oklab,var(--card) 92%, transparent);
      box-shadow:0 10px 30px rgba(0,0,0,.18);
    }
    .pad{padding:16px}

    .toolbar{display:flex;gap:10px;flex-wrap:wrap;align-items:center;justify-content:space-between}
    .control{
      padding:11px 12px;border-radius:14px;border:1px solid var(--border);
      background:color-mix(in oklab,var(--card) 88%, transparent);color:var(--text);outline:none;
    }
    .control:focus{border-color:color-mix(in oklab,var(--brand) 55%, var(--border));box-shadow:0 0 0 6px color-mix(in oklab,var(--brand) 20%, transparent)}

    .products{display:grid;grid-template-columns:repeat(3,1fr);gap:14px;margin-top:14px}
    @media (max-width:960px){.products{grid-template-columns:repeat(2,1fr)}}
    @media (max-width:640px){.products{grid-template-columns:1fr}}

    .product{overflow:hidden;position:relative}
    .product__img{
      width:100%;height:180px;object-fit:cover;display:block;
      filter:saturate(1.1) contrast(1.02);
      transform:scale(1.02);transition:transform .25s ease;
    }
    .product:hover .product__img{transform:scale(1.07)}
    .product__body{padding:14px}
    .product__title{font-weight:900;letter-spacing:.2px;margin:2px 0 6px}
    .product__meta{display:flex;gap:8px;flex-wrap:wrap;align-items:center;margin:8px 0 10px}
    .price{font-size:18px;font-weight:900}
    .product__actions{display:flex;gap:10px;margin-top:12px}
    .product__actions .btn{flex:1}

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

    /* Toast */
    .toast{
      position:fixed;left:50%;bottom:22px;transform:translateX(-50%) translateY(10px);
      background:color-mix(in oklab,var(--card) 92%, transparent);
      border:1px solid var(--border);color:var(--text);
      padding:10px 14px;border-radius:999px;box-shadow:var(--shadow);
      opacity:0;transition:all .22s ease;z-index:9999;
    }
    .toast.on{opacity:1;transform:translateX(-50%) translateY(0)}
  </style>
</head>

<body>
@php
  $products = $products ?? [
    ['id_producto'=>'P-1001','nombre'=>'Audífonos Inalámbricos Nova','precio'=>189900,'descripcion'=>'Cancelación de ruido, estuche de carga, 24h de batería.','imagen'=>'https://picsum.photos/seed/nova/900/600','estado'=>'Disponible'],
    ['id_producto'=>'P-1002','nombre'=>'Teclado Mecánico Pulse','precio'=>299900,'descripcion'=>'Switches táctiles, RGB suave, chasis metálico.','imagen'=>'https://picsum.photos/seed/pulse/900/600','estado'=>'Disponible'],
    ['id_producto'=>'P-1003','nombre'=>'Mouse Ergonómico Flow','precio'=>119900,'descripcion'=>'Agarre cómodo, sensor preciso, ideal para largas jornadas.','imagen'=>'https://picsum.photos/seed/flow/900/600','estado'=>'Agotado'],
    ['id_producto'=>'P-1004','nombre'=>'Monitor 27” UltraView','precio'=>899900,'descripcion'=>'Panel IPS, 75Hz, colores vivos, biseles delgados.','imagen'=>'https://picsum.photos/seed/ultraview/900/600','estado'=>'Disponible'],
    ['id_producto'=>'P-1005','nombre'=>'Cámara Web StreamPro','precio'=>159900,'descripcion'=>'1080p, micrófono integrado, ideal para clases y streaming.','imagen'=>'https://picsum.photos/seed/streampro/900/600','estado'=>'Inactivo'],
  ];
@endphp

<header class="topbar">
  <div class="container topbar__inner">
    <a class="brand" href="/products">
      <span class="brand__logo">🛍️</span>
      <span><strong>Store</strong><span class="muted">UI</span></span>
    </a>

    <nav class="nav">
      <a class="active" href="/products">Productos</a>
      <a href="/products/create">Crear</a>
    </nav>

    <div class="actions">
      <div class="search">
        <input id="q" type="search" placeholder="Buscar producto..." autocomplete="off">
        <span class="icon">⌕</span>
      </div>
      <button class="btn btn--ghost" id="themeBtn" type="button" title="Cambiar tema">🌙</button>
    </div>
  </div>
</header>

<main>
  <div class="container">
    <section class="hero">
      <h1>Catálogo de productos</h1>
      <p>Lista de 5 productos con filtros, búsqueda y tarjetas interactivas.</p>
    </section>

    <div class="grid">
      <section class="span-8">
        <div class="card pad">
          <div class="toolbar">
            <div class="muted">Tip: filtra por estado y ordena por precio.</div>
            <div style="display:flex;gap:10px;flex-wrap:wrap">
              <select id="estado" class="control">
                <option value="Todos">Todos los estados</option>
                <option value="Disponible">Disponible</option>
                <option value="Agotado">Agotado</option>
                <option value="Inactivo">Inactivo</option>
              </select>

              <select id="sort" class="control">
                <option value="none">Ordenar por precio</option>
                <option value="asc">Menor → Mayor</option>
                <option value="desc">Mayor → Menor</option>
              </select>

              <a class="btn btn--primary" href="/products/create">➕ Crear producto</a>
            </div>
          </div>
        </div>

        <div class="products" id="grid">
          @foreach($products as $p)
            @php
              $e = strtolower($p['estado']);
              $badge = $e==='disponible' ? 'badge--ok' : ($e==='agotado' ? 'badge--warn' : 'badge--bad');
            @endphp

            <article class="card product"
              data-name="{{ mb_strtolower($p['nombre']) }}"
              data-estado="{{ $p['estado'] }}"
              data-precio="{{ $p['precio'] }}"
            >
              <img class="product__img" src="{{ $p['imagen'] }}" alt="Imagen de {{ $p['nombre'] }}" loading="lazy">
              <div class="product__body">
                <div class="product__title">{{ $p['nombre'] }}</div>
                <div class="muted" style="line-height:1.35">{{ $p['descripcion'] }}</div>

                <div class="product__meta">
                  <span class="badge {{ $badge }}">● {{ $p['estado'] }}</span>
                  <span class="badge">ID: {{ $p['id_producto'] }}</span>
                </div>

                <div style="display:flex;justify-content:space-between;gap:10px;align-items:baseline">
                  <div class="price">$ {{ number_format($p['precio'],0,',','.') }}</div>
                  <span class="muted" style="font-size:13px">★ ★ ★ ★ ☆</span>
                </div>

                <div class="product__actions">
                  <a class="btn" href="/products/{{ $p['id_producto'] }}">Ver</a>
                  <button class="btn btn--ghost" type="button"
                    onclick="toast('Favorito: {{ addslashes($p['nombre']) }}')">♡</button>
                </div>
              </div>
            </article>
          @endforeach
        </div>
      </section>

      <aside class="span-4">
        <div class="card pad">
          <h3 style="margin:0 0 6px">Panel rápido</h3>
          <p class="muted" style="margin:0 0 10px">Resumen del catálogo (demo).</p>

          @php
            $dis = collect($products)->where('estado','Disponible')->count();
            $ago = collect($products)->where('estado','Agotado')->count();
            $ina = collect($products)->where('estado','Inactivo')->count();
          @endphp

          <div class="panel__row"><span class="muted">Disponibles</span><strong>{{ $dis }}</strong></div>
          <div class="panel__row"><span class="muted">Agotados</span><strong>{{ $ago }}</strong></div>
          <div class="panel__row"><span class="muted">Inactivos</span><strong>{{ $ina }}</strong></div>

          <div style="display:grid;gap:10px;margin-top:12px">
            <button class="btn" type="button" onclick="toast('Exportación simulada ✅')">Exportar (demo)</button>
            <a class="btn btn--primary" href="/products/create">Crear producto</a>
          </div>
        </div>

        <div class="card pad" style="margin-top:14px">
          <h4 style="margin:0 0 6px">Promo</h4>
          <p class="muted" style="margin:0">Envío gratis en compras superiores a $300.000 (demo).</p>
          <div style="margin-top:10px" class="badge badge--ok">🚚 Envío rápido</div>
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
      <p class="muted" style="margin:8px 0 0">Vistas con CSS moderno, responsive e interacciones.</p>
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

  // Toast
  function toast(msg){
    const t = document.createElement('div');
    t.className = 'toast';
    t.textContent = msg;
    document.body.appendChild(t);
    requestAnimationFrame(()=>t.classList.add('on'));
    setTimeout(()=>t.classList.remove('on'), 2200);
    setTimeout(()=>t.remove(), 2600);
  }

  // Búsqueda + filtro + orden
  const q = document.getElementById('q');
  const estado = document.getElementById('estado');
  const sort = document.getElementById('sort');
  const grid = document.getElementById('grid');

  function apply(){
    const query = (q.value||'').trim().toLowerCase();
    const est = estado.value;
    const cards = [...grid.querySelectorAll('article.product')];

    cards.forEach(c=>{
      const name = c.dataset.name || '';
      const e = c.dataset.estado || '';
      const okName = !query || name.includes(query);
      const okEstado = est === 'Todos' || e === est;
      c.style.display = (okName && okEstado) ? '' : 'none';
    });

    const visible = cards.filter(c=>c.style.display !== 'none');
    if(sort.value !== 'none'){
      visible.sort((a,b)=>{
        const pa = Number(a.dataset.precio||0);
        const pb = Number(b.dataset.precio||0);
        return sort.value === 'asc' ? pa - pb : pb - pa;
      });
      visible.forEach(v=>grid.appendChild(v));
    }
  }
  [q, estado, sort].forEach(el=>el.addEventListener('input', apply));
  apply();
</script>
</body>
</html>
