{{-- resources/views/products/create.blade.php --}}
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Crear producto | StoreUI</title>

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

    /* Form */
    form{display:grid;grid-template-columns:repeat(2,1fr);gap:14px}
    @media (max-width:760px){form{grid-template-columns:1fr}}
    label{display:block;margin:0 0 7px;font-weight:800;letter-spacing:.2px}
    .control, textarea, select{
      width:100%;padding:11px 12px;border-radius:14px;border:1px solid var(--border);
      background:color-mix(in oklab,var(--card) 88%, transparent);color:var(--text);outline:none;
    }
    .control:focus, textarea:focus, select:focus{
      border-color:color-mix(in oklab,var(--brand) 55%, var(--border));
      box-shadow:0 0 0 6px color-mix(in oklab,var(--brand) 20%, transparent);
    }
    textarea{min-height:120px;resize:vertical}
    .help{color:var(--muted);font-size:13px;margin-top:6px}
    .full{grid-column:1/-1}

    /* Preview */
    .preview{
      border:1px solid var(--border);border-radius:var(--r2);overflow:hidden;
      background:color-mix(in oklab,var(--card) 90%, transparent);
    }
    .preview img{width:100%;height:260px;object-fit:cover;display:block}
    .preview .pbody{padding:12px 14px}
    .price{font-size:24px;font-weight:900;margin-top:10px}

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
<header class="topbar">
  <div class="container topbar__inner">
    <a class="brand" href="/products">
      <span class="brand__logo">🛍️</span>
      <span><strong>Store</strong><span class="muted">UI</span></span>
    </a>

    <nav class="nav">
      <a href="/products">Productos</a>
      <a class="active" href="/products/create">Crear</a>
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
      <h1>Crear producto</h1>
      <p>Formulario completo con preview de imagen, badge de estado y contador de descripción.</p>
    </section>

    <div class="grid">
      <section class="span-8">
        <div class="card pad">
          <form method="POST" action="/products" enctype="multipart/form-data">
            @csrf

            <div>
              <label for="id_producto">ID Producto</label>
              <input class="control" id="id_producto" name="id_producto" type="text" placeholder="Ej: P-1006" required>
              <div class="help">Debe ser único (recomendado: prefijo <strong>P-</strong>).</div>
            </div>

            <div>
              <label for="nombre">Nombre</label>
              <input class="control" id="nombre" name="nombre" type="text" placeholder="Ej: Parlante Bluetooth" maxlength="80" required>
              <div class="help">Máx. 80 caracteres.</div>
            </div>

            <div>
              <label for="precio">Precio</label>
              <input class="control" id="precio" name="precio" type="number" min="0" step="100" placeholder="Ej: 199900" required>
              <div class="help">En COP sin puntos (ej: 199900). <span id="precioHuman" class="badge" style="margin-left:6px">$ 0</span></div>
            </div>

            <div>
              <label for="estado">Estado</label>
              <select id="estado" name="estado" required>
                <option value="Disponible">Disponible</option>
                <option value="Agotado">Agotado</option>
                <option value="Inactivo">Inactivo</option>
              </select>
              <div class="help">Define si el producto se muestra y cómo se ve en el catálogo.</div>
            </div>

            <div class="full">
              <label for="descripcion">Descripción</label>
              <textarea id="descripcion" name="descripcion" maxlength="240" placeholder="Describe el producto..." required></textarea>
              <div class="help"><span id="descCount">0</span>/240</div>
            </div>

            <div class="full">
              <label for="imagen">Imagen</label>
              <input class="control" id="imagen" name="imagen" type="file" accept="image/*" required>
              <div class="help">Se mostrará un preview automáticamente (JPG/PNG recomendado).</div>
            </div>

            <div class="full" style="display:flex;gap:10px;flex-wrap:wrap;justify-content:flex-end">
              <a class="btn btn--ghost" href="/products">Cancelar</a>
              <button class="btn btn--primary" type="submit">Guardar producto</button>
            </div>
          </form>
        </div>
      </section>

      <aside class="span-4">
        <div class="preview">
          <img id="imgPreview" src="https://picsum.photos/seed/preview/1200/800" alt="Preview">
          <div class="pbody">
            <div id="estadoBadge" class="badge badge--ok">● Disponible</div>
            <h3 id="namePreview" style="margin:10px 0 6px">Nombre del producto</h3>
            <div id="descPreview" class="muted">La descripción aparecerá aquí…</div>
            <div id="pricePreview" class="price">$ 0</div>
          </div>
        </div>

        <div class="card pad" style="margin-top:14px">
          <h4 style="margin:0 0 6px">Tips</h4>
          <ul class="muted" style="margin:0;padding-left:18px;line-height:1.6">
            <li>Usa fotos claras y bien iluminadas.</li>
            <li>Descripción corta y directa (máx 240).</li>
            <li>Precio en COP sin separadores.</li>
          </ul>
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
      <p class="muted" style="margin:8px 0 0">Formulario con preview y validaciones visuales.</p>
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

  // Preview en vivo
  const nombre = document.getElementById('nombre');
  const precio = document.getElementById('precio');
  const descripcion = document.getElementById('descripcion');
  const imagen = document.getElementById('imagen');
  const estado = document.getElementById('estado');

  const namePreview = document.getElementById('namePreview');
  const descPreview = document.getElementById('descPreview');
  const pricePreview = document.getElementById('pricePreview');
  const precioHuman = document.getElementById('precioHuman');
  const descCount = document.getElementById('descCount');
  const imgPreview = document.getElementById('imgPreview');
  const estadoBadge = document.getElementById('estadoBadge');

  const money = (n)=> '$ ' + (Number(n||0)).toLocaleString('es-CO');

  function sync(){
    namePreview.textContent = nombre.value.trim() || 'Nombre del producto';
    descPreview.textContent = descripcion.value.trim() || 'La descripción aparecerá aquí…';
    pricePreview.textContent = money(precio.value);
    precioHuman.textContent = money(precio.value);
    descCount.textContent = (descripcion.value||'').length;

    estadoBadge.classList.remove('badge--ok','badge--warn','badge--bad');
    if(estado.value === 'Disponible'){ estadoBadge.classList.add('badge--ok'); }
    else if(estado.value === 'Agotado'){ estadoBadge.classList.add('badge--warn'); }
    else { estadoBadge.classList.add('badge--bad'); }
    estadoBadge.textContent = '● ' + estado.value;
  }

  [nombre, precio, descripcion, estado].forEach(el=>el.addEventListener('input', sync));
  sync();

  imagen.addEventListener('change', (e)=>{
    const file = e.target.files?.[0];
    if(!file) return;
    const url = URL.createObjectURL(file);
    imgPreview.src = url;
  });
</script>
</body>
</html>
