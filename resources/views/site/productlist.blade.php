@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    @foreach ($produtos as $produto)
                        <div class="card" style="width: 18rem;">
                            <img class="card-img-top" src="{{ $produto->caminho_imagem }}" alt="Imagem do produto"
                                height='200'>
                            <div class="card-body">
                                <h3 class="card-title font-weight-bold">{{ $produto->nome_do_produto }}</h3>
                                <p class="card-text">{{ $produto->descricao }}</p>
                                <p class="card-category font-weight-bold">R$ {{ $produto->preco }}</p>
                                @if ($produto->quantidade > 0)
                                    <a href="#" class="btn btn-primary">Comprar</a>
                                @else
                                    <a href="#" class="btn btn-primary disabled" aria-disabled="true">SEM
                                        ESTOQUE</a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
