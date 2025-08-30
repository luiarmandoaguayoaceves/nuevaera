@props(['categorias' => collect(), 'tallas' => []])

<form id="filters" class="grid grid-cols-2 md:flex gap-2">
  <input id="q" type="text" placeholder="Buscar modelo o nombre…"
         class="col-span-2 md:col-span-1 rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm placeholder:text-gray-400 focus:border-gray-900 focus:ring-0">

  <select id="cat" class="rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm">
    <option value="">Categoría</option>
    @foreach($categorias as $c)
      @php $label = is_object($c) ? $c->nombre : $c; @endphp
      <option value="{{ strtolower($label) }}">{{ $label }}</option>
    @endforeach
  </select>

  <select id="size" class="rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm">
    <option value="">Talla</option>
    @foreach($tallas as $t)
      <option>{{ $t }}</option>
    @endforeach
  </select>
</form>
