<div class="wrapper wrapper-full-page">
    <div class="page-header login-page header-filter" filter-color="black"
        style="background-image: url('{{ asset('material') }}/img/perfume_fundo.jpg'); background-size: cover; background-position: top center;align-items: center;"
        data-color="purple">
        <!--   you can change the color of the filter page using: data-color="blue | purple | green | orange | red | rose " -->
        @yield('content')
        @include('layouts.footers.adapti')
    </div>
</div>
