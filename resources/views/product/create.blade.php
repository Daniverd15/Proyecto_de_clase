@extends('layout.app')

@section('content')
<main>
    <div class="container">
        <section class="hero">
            <h1>Crear producto</h1>
            <p>Campos: id_producto, nombre, precio, descripcion, imagen, estado.</p>
        </section>

        <div style="display:grid;grid-template-columns:1.2fr .8fr;gap:14px">
            <section class="card pad">
                <form class="form" method="POST" action="{{ route('product.store') }}" enctype="multipart/form-data">
                    @csrf

                    

                    <div class="field">
                        <label for="nombre">Nombre</label>
                        <input
                            id="nombre"
                            name="nombre"
                            type="text"
                            maxlength="80"
                            placeholder="Nombre del producto"
                            value="{{ old('nombre') }}"
                        >
                        @error('nombre')
                            <span style="color:red;font-size:14px">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="field">
                        <label for="precio">Precio</label>
                        <input
                            id="precio"
                            name="precio"
                            type="number"
                            min="0"
                            step="100"
                            placeholder="199900"
                            value="{{ old('precio') }}"
                        >
                        @error('precio')
                            <span style="color:red;font-size:14px">{{ $message }}</span>
                        @enderror
                        <div class="help">
                            <span id="precioHuman" class="badge">$ 0</span>
                        </div>
                    </div>

                    <div class="field">
                        <label for="category">Categoría</label>
                        <select id="category" name="category">
                            @foreach ($category as $cat)
                                <option value="{{ $cat->id }}" {{ old('category') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category')
                            <span style="color:red;font-size:14px">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="field full">
                        <label for="descripcion">Descripción</label>
                        <textarea
                            id="descripcion"
                            name="descripcion"
                            maxlength="240"
                            placeholder="Describe el producto..."
                        >{{ old('descripcion') }}</textarea>
                        @error('description')
                            <span style="color:red;font-size:14px">{{ $message }}</span>
                        @enderror
                        <div class="help">
                            <span id="descCount">0</span>/240
                        </div>
                    </div>

                    <div class="field full">
                        <label for="imagen">Imagen</label>
                        <input id="imagen" name="imagen" type="file" accept="image/*">
                        @error('imagen')
                            <span style="color:red;font-size:14px">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="full" style="display:flex;gap:10px;flex-wrap:wrap;justify-content:flex-end">
                        <a class="btn btn--ghost" href="{{ url('/products') }}">Cancelar</a>
                        <button class="btn btn--primary" type="submit">Guardar</button>
                    </div>
                </form>
            </section>

            <aside class="preview">
                <img id="imgPreview" src="https://picsum.photos/seed/preview/1200/800" alt="Preview">
                <div class="pbody">
                    <div id="estadoBadge" class="badge badge--ok">● Categoría</div>
                    <h3 id="namePreview" style="margin:10px 0 6px">Nombre del producto</h3>
                    <div id="descPreview" class="muted">La descripción aparecerá aquí…</div>
                    <div id="pricePreview" style="font-size:26px;font-weight:1000;margin-top:10px">$ 0</div>
                </div>
            </aside>
        </div>
    </div>
</main>

<script>
    // Tema
    const root = document.documentElement;
    const themeBtn = document.getElementById('themeBtn');
    const saved = localStorage.getItem('theme');

    if (saved) {
        root.dataset.theme = saved;
    }

    if (themeBtn) {
        themeBtn.textContent = root.dataset.theme === 'light' ? '🌙' : '☀️';

        themeBtn.onclick = () => {
            const n = root.dataset.theme === 'light' ? 'dark' : 'light';
            root.dataset.theme = n;
            localStorage.setItem('theme', n);
            themeBtn.textContent = n === 'light' ? '🌙' : '☀️';
        };
    }

    // Preview en vivo
    const nombre = document.getElementById('nombre');
    const precio = document.getElementById('precio');
    const descripcion = document.getElementById('descripcion');
    const imagen = document.getElementById('imagen');
    const category = document.getElementById('category');

    const namePreview = document.getElementById('namePreview');
    const descPreview = document.getElementById('descPreview');
    const pricePreview = document.getElementById('pricePreview');
    const precioHuman = document.getElementById('precioHuman');
    const descCount = document.getElementById('descCount');
    const imgPreview = document.getElementById('imgPreview');
    const estadoBadge = document.getElementById('estadoBadge');

    const money = n => '$ ' + (Number(n || 0)).toLocaleString('es-CO');

    function sync() {
        namePreview.textContent = nombre.value.trim() || 'Nombre del producto';
        descPreview.textContent = descripcion.value.trim() || 'La descripción aparecerá aquí…';
        pricePreview.textContent = money(precio.value);
        precioHuman.textContent = money(precio.value);
        descCount.textContent = (descripcion.value || '').length;

        const textoCategoria = category.options[category.selectedIndex]?.text || 'Categoría';
        estadoBadge.textContent = '● ' + textoCategoria;
    }

    [nombre, precio, descripcion, category].forEach(el => {
        if (el) {
            el.addEventListener('input', sync);
            el.addEventListener('change', sync);
        }
    });

    sync();

    if (imagen) {
        imagen.addEventListener('change', (e) => {
            const f = e.target.files?.[0];
            if (!f) return;
            imgPreview.src = URL.createObjectURL(f);
        });
    }
</script>
@endsection