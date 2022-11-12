<div id="sidebar">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header">
            <i class="fa-solid fa-xmark sidebar-hide"></i>
            <div class="d-flex justify-content-between">
                <div class="logo">
                    {{-- <a href="index.html"><img src="{{ asset('assets/images/logo/logo.png') }}" alt="Logo"
                            srcset=""></a> --}}
                </div>
                <div class="toggler">
                    <a class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Opciones</li>
                @foreach (session('submodulos') as $submodulo)
                    <li class="sidebar-item">
                        <a href="{{ route('operacion', $submodulo->id_modulo) }}" class='sidebar-link enlace-sidebar'>
                            <div class="icono-sidebar">
                                <i class="{{ $submodulo->icono }}"></i>
                            </div>
                            <span>{{ $submodulo->desc_modulo }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
    </div>
</div>
