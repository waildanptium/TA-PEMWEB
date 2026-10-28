<x-toko-layout title="Pegawai">
    <h1 class="text-2xl font-bold mb-4">Manajemen Pegawai</h1>

    <form method="POST" action="{{ route('admin.pegawai.store') }}" class="card grid md:grid-cols-5 gap-2 mb-6">
        @csrf
        <input name="name" placeholder="Nama" class="input" required>
        <input type="email" name="email" placeholder="Email" class="input" required>
        <input type="password" name="password" placeholder="Password (min 8)" class="input" required>
        <select name="role" class="input"><option value="kasir">Kasir</option><option value="admin">Admin</option></select>
        <button class="btn">Buat Akun</button>
    </form>

    <table class="tbl">
        <tr><th>Nama</th><th>Email</th><th>Role</th><th>Status</th><th></th></tr>
        @foreach($employees as $e)
            <tr>
                <td>{{ $e->name }}</td>
                <td>{{ $e->email }}</td>
                <td>{{ $e->role }}</td>
                <td>{{ $e->is_active ? 'Aktif' : 'Nonaktif' }}</td>
                <td>
                    @if($e->id !== auth()->id())
                        <form method="POST" action="{{ route('admin.pegawai.update', $e) }}">
                            @csrf @method('PUT')
                            <button class="btn {{ $e->is_active ? 'btn-red' : '' }}">{{ $e->is_active ? 'Nonaktifkan' : 'Aktifkan' }}</button>
                        </form>
                    @endif
                </td>
            </tr>
        @endforeach
    </table>
</x-toko-layout>