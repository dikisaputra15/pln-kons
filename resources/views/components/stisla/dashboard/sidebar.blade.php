<div class="main-sidebar sidebar-style-2">
  <aside id="sidebar-wrapper" aria-label="Menu utama">
    <div class="sidebar-brand">
      <a href="{{ route('home') }}">{{ config('app.name') }}</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
      <a href="{{ route('home') }}" aria-label="Dashboard"><i class="fas fa-fire" aria-hidden="true"></i></a>
    </div>
    <ul class="sidebar-menu">
      <li class="menu-header">
        <a href="{{ route('home') }}" class="nav-link"><i class="fas fa-fire"></i><span>Dashboard</span></a>
      </li>
      <li class="menu-header">Data Master</li>
      <li @class(['dropdown', 'active' => request()->routeIs('tarifs.*', 'dayas.*', 'uids.*', 'units.*', 'users.*', 'roles.*', 'gis.*', 'jenispengadaans.*', 'satuans.*', 'kategoris.*', 'jenispekerjaans.*', 'subjenispekerjaans.*', 'penyambungans.*')])>
        <a href="#" class="nav-link has-dropdown"><i class="fas fa-columns"></i> <span>Master</span></a>
        <ul class="dropdown-menu">
          <li @class(['active' => request()->routeIs('uids.*')])>
            <a class="nav-link" href="{{ route('uids.index') }}" @if(request()->routeIs('uids.*')) aria-current="true" @endif>UID</a>
          </li>
          <li @class(['active' => request()->routeIs('units.*')])>
            <a class="nav-link" href="{{ route('units.index') }}" @if(request()->routeIs('units.*')) aria-current="true" @endif>Unit</a>
          </li>
          @if (auth()->user()?->hasRole(\App\Models\User::ADMIN_ROLE, 'web'))
            <li @class(['active' => request()->routeIs('roles.*')])>
              <a class="nav-link" href="{{ route('roles.index') }}" @if(request()->routeIs('roles.*')) aria-current="true" @endif>Role</a>
            </li>
            <li @class(['active' => request()->routeIs('users.*')])>
              <a class="nav-link" href="{{ route('users.index') }}" @if(request()->routeIs('users.*')) aria-current="true" @endif>User</a>
            </li>
          @endif
          <li @class(['active' => request()->routeIs('tarifs.*')])>
            <a class="nav-link" href="{{ route('tarifs.index') }}" @if(request()->routeIs('tarifs.*')) aria-current="true" @endif>Tarif</a>
          </li>
          <li @class(['active' => request()->routeIs('dayas.*')])>
            <a class="nav-link" href="{{ route('dayas.index') }}" @if(request()->routeIs('dayas.*')) aria-current="true" @endif>Daya</a>
          </li>
          <li @class(['active' => request()->routeIs('gis.*')])>
            <a class="nav-link" href="{{ route('gis.index') }}" @if(request()->routeIs('gis.*')) aria-current="true" @endif>GI</a>
          </li>
          <li @class(['active' => request()->routeIs('jenispengadaans.*')])>
            <a class="nav-link" href="{{ route('jenispengadaans.index') }}" @if(request()->routeIs('jenispengadaans.*')) aria-current="true" @endif>Jenis Pengadaan</a>
          </li>
          <li @class(['active' => request()->routeIs('satuans.*')])>
            <a class="nav-link" href="{{ route('satuans.index') }}" @if(request()->routeIs('satuans.*')) aria-current="true" @endif>Satuan</a>
          </li>
          <li @class(['active' => request()->routeIs('kategoris.*')])>
            <a class="nav-link" href="{{ route('kategoris.index') }}" @if(request()->routeIs('kategoris.*')) aria-current="true" @endif>Kategori</a>
          </li>
          <li @class(['active' => request()->routeIs('jenispekerjaans.*')])>
            <a class="nav-link" href="{{ route('jenispekerjaans.index') }}" @if(request()->routeIs('jenispekerjaans.*')) aria-current="true" @endif>Jenis Pekerjaan</a>
          </li>
          <li @class(['active' => request()->routeIs('subjenispekerjaans.*')])>
            <a class="nav-link" href="{{ route('subjenispekerjaans.index') }}" @if(request()->routeIs('subjenispekerjaans.*')) aria-current="true" @endif>Sub Jenis Pekerjaan</a>
          </li>
          <li @class(['active' => request()->routeIs('penyambungans.*')])>
            <a class="nav-link" href="{{ route('penyambungans.index') }}" @if(request()->routeIs('penyambungans.*')) aria-current="true" @endif>Penyambungan</a>
          </li>
        </ul>
      </li>

      <li class="menu-header">Data Proses</li>
      <li class="dropdown">
        <a href="#" class="nav-link has-dropdown"><i class="fas fa-th-large"></i> <span>Proses</span></a>
        <ul class="dropdown-menu">
          <li><a class="nav-link" href="{{ asset('stisla/dist/components-article.html') }}">Trafo GI</a></li>
        <li><a class="nav-link beep beep-sidebar" href="{{ asset('stisla/dist/components-avatar.html') }}">Penyulang</a></li>
        <li><a class="nav-link" href="{{ asset('stisla/dist/components-chat-box.html') }}">Gardu Distribusi</a></li>
        <li><a class="nav-link beep beep-sidebar" href="{{ asset('stisla/dist/components-empty-state.html') }}">Data Pelanggan</a></li>
          <li><a class="nav-link beep beep-sidebar" href="{{ asset('stisla/dist/components-hero.html') }}">Daya Pelanggan</a></li>
        <li><a class="nav-link" href="{{ asset('stisla/dist/components-multiple-upload.html') }}">Item</a></li>
          <li><a class="nav-link beep beep-sidebar" href="{{ asset('stisla/dist/components-pricing.html') }}">List Template</a></li>
        <li><a class="nav-link" href="{{ asset('stisla/dist/components-statistic.html') }}">Template</a></li>
        </ul>
      </li>
       <li class="menu-header">Data Report</li>
      <li class="dropdown">
        <a href="#" class="nav-link has-dropdown"><i class="far fa-file-alt"></i> <span>Report</span></a>
        <ul class="dropdown-menu">
          <li><a class="nav-link" href="{{ asset('stisla/dist/forms-advanced-form.html') }}">RAB</a></li>
        </ul>
      </li>

    </ul>
  </aside>
</div>
