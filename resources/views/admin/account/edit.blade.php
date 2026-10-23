@extends('layouts.admin')
@section('title', 'Akun & Admin')

@section('content')
  <div class="grid-2">
    <form method="post" action="{{ route('admin.account.profile') }}" class="panel">
      @csrf @method('PUT')
      <div class="panel-head"><h3>Profil saya</h3></div>
      @include('admin.partials.field', ['name' => 'name', 'label' => 'Nama', 'value' => $user->name, 'required' => true])
      @include('admin.partials.field', ['name' => 'email', 'label' => 'Email (untuk login)', 'value' => $user->email, 'type' => 'email', 'required' => true])
      <div class="savebar tight"><button class="btn btn-p" type="submit">Simpan profil</button></div>
    </form>

    <form method="post" action="{{ route('admin.account.password') }}" class="panel">
      @csrf @method('PUT')
      <div class="panel-head"><h3>Ganti password</h3></div>
      <div class="field"><label for="cp">Password saat ini</label><input id="cp" type="password" name="current_password" required autocomplete="current-password"></div>
      <div class="field"><label for="np">Password baru</label><input id="np" type="password" name="password" required autocomplete="new-password"><small>Minimal 10 karakter, berisi huruf dan angka.</small></div>
      <div class="field"><label for="np2">Ulangi password baru</label><input id="np2" type="password" name="password_confirmation" required autocomplete="new-password"></div>
      <div class="savebar tight"><button class="btn btn-p" type="submit">Ganti password</button></div>
    </form>
  </div>

  <section class="panel">
    <div class="panel-head"><h3>Daftar admin</h3></div>
    @error('admin')<div class="alert err">{{ $message }}</div>@enderror
    <table class="tbl">
      <thead><tr><th>Nama</th><th>Email</th><th></th></tr></thead>
      <tbody>
        @foreach ($admins as $a)
          <tr>
            <td>{{ $a->name }} @if ($a->is($user))<span class="tag tag-blue">Anda</span>@endif</td>
            <td>{{ $a->email }}</td>
            <td class="actions">
              @unless ($a->is($user))
                <form method="post" action="{{ route('admin.account.admins.destroy', $a) }}" data-confirm="Hapus akses admin {{ $a->name }}?">
                  @csrf @method('DELETE')<button class="btn btn-danger btn-sm" type="submit">Hapus</button>
                </form>
              @endunless
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>

    <form method="post" action="{{ route('admin.account.admins.store') }}" class="add-admin">
      @csrf
      <h4>Tambah admin</h4>
      <div class="grid-3">
        @include('admin.partials.field', ['name' => 'new_name', 'label' => 'Nama', 'required' => true])
        @include('admin.partials.field', ['name' => 'new_email', 'label' => 'Email', 'type' => 'email', 'required' => true])
        <div class="field"><label for="f_new_password">Password awal <i>*</i></label><input id="f_new_password" type="password" name="new_password" required autocomplete="new-password"><small>Min. 10 karakter, huruf & angka.</small></div>
      </div>
      <div class="savebar tight"><button class="btn btn-p" type="submit">Tambah admin</button></div>
    </form>
  </section>
@endsection
