<x-app-layout>
<div class="min-h-screen bg-gray-900 text-white p-6">
    <h2 class="text-2xl font-bold mb-4">Editar Produto</h2>

    <form action="{{ route('admin.inventario.update', $inventario->id) }}" method="POST" class="bg-gray-800 p-6 rounded shadow">
        @csrf
        @method('PATCH')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block mb-1">Nome do Produto</label>
                <input type="text" name="nome_produto" value="{{ $inventario->nome_produto }}" class="w-full p-2 rounded bg-gray-700 text-white">
            </div>
            <div>
                <label class="block mb-1">Categoria</label>
                <input type="text" name="categoria" value="{{ $inventario->categoria }}" class="w-full p-2 rounded bg-gray-700 text-white">
            </div>
            <div>
                <label class="block mb-1">Quantidade</label>
                <input type="number" name="quantidade" value="{{ $inventario->quantidade }}" class="w-full p-2 rounded bg-gray-700 text-white">
            </div>
            <div>
                <label class="block mb-1">Quantidade Mínima</label>
                <input type="number" name="quantidade_minima" value="{{ $inventario->quantidade_minima }}" class="w-full p-2 rounded bg-gray-700 text-white">
            </div>
            <div>
                <label class="block mb-1">Preço</label>
                <input type="text" name="preco" value="{{ $inventario->preco }}" class="w-full p-2 rounded bg-gray-700 text-white">
            </div>
        </div>
        <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded">Atualizar</button>
    </form>
</div>
</x-app-layout>