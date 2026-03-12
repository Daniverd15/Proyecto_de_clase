@extends('layout.app')

@section('content')

<main>
  <div class="container">
    <section class="hero">
      <h1>Catálogo (INDEX)</h1>
      <p>Aquí se muestran 5 productos en lista. No hay especificaciones aquí.</p>
    </section>

    <section class="catalogGrid">
      @foreach($misproductos as $p)
        <article class="card catalogCard">
          @if($p->image)
            <img class="catalogImage" src="{{ asset('storage/'.$p->image) }}" alt="Imagen">
          @else
            <img class="catalogImage" src="" alt="Imagen por defecto">
          @endif

          <h3 class="catalogTitle">{{ $p->name }}</h3>

          <div class="catalogMeta">
            <span class="badge">●ID: {{ $p->category_id }}</span>
            <span class="badge">Description: {{ $p->description }}</span>
          </div>

          <div style="display:flex;justify-content:space-between;align-items:baseline;gap:10px">
            <div class="price">$ {{ number_format($p->price,0,',','.') }}</div>
            <span class="muted" style="font-size:13px">★ ★ ★ ★ ☆</span>
          </div>

          <div class="catalogActions">
            <a class="btn btn--primary" href="{{ url('/products/'.$p->id_producto) }}">Ver</a>
            <button class="btn btn--ghost" type="button" onclick="toast('Favorito: {{ addslashes($p->name) }}')">♡</button>
          </div>
        </article>
      @endforeach
    </section>
  </div>
</main>

<script>
  const root = document.documentElement;
  const themeBtn = document.getElementById('themeBtn');

  const saved = localStorage.getItem('theme');
  if (saved) root.dataset.theme = saved;

  if (themeBtn) {
    themeBtn.textContent = root.dataset.theme === 'light' ? '🌙' : '☀️';
    themeBtn.onclick = () => {
      const n = root.dataset.theme === 'light' ? 'dark' : 'light';
      root.dataset.theme = n;
      localStorage.setItem('theme', n);
      themeBtn.textContent = n === 'light' ? '🌙' : '☀️';
    };
  }

  function toast(msg){
    const t = document.createElement('div');
    t.className = 'toast';
    t.textContent = msg;
    document.body.appendChild(t);
    requestAnimationFrame(() => t.classList.add('on'));
    setTimeout(() => t.classList.remove('on'), 2200);
    setTimeout(() => t.remove(), 2600);
  }
</script>

@endsection


