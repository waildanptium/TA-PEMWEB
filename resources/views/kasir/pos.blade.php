<x-toko-layout title="POS Kasir">
    <script>
        window.POS_PRODUCTS = @json($products);
        window.POS_URL = "{{ route('kasir.pos.store') }}";
        window.POS_CSRF = "{{ csrf_token() }}";

        function pos(products) {
            return {
                products, q: '', cart: [], method: 'tunai', paid: 0, discount: 0, error: '', loading: false,
                get filtered() {
                    const q = this.q.toLowerCase();
                    return this.products.filter(p => p.name.toLowerCase().includes(q) || p.code.toLowerCase().includes(q)).slice(0, 40);
                },
                addByCode() {
                    const p = this.products.find(p => p.code.toLowerCase() === this.q.trim().toLowerCase());
                    if (p) { this.add(p); this.q = ''; }
                },
                add(p) {
                    const item = this.cart.find(c => c.id === p.id);
                    if (item) { if (item.qty < p.stock) item.qty++; }
                    else if (p.stock > 0) this.cart.push({ id: p.id, name: p.name, price: p.price, stock: p.stock, qty: 1 });
                },
                remove(i) { this.cart.splice(i, 1); },
                get subtotal() { return this.cart.reduce((s, c) => s + c.price * c.qty, 0); },
                get total() { return Math.max(this.subtotal - (+this.discount || 0), 0); },
                get change() { return (+this.paid || 0) - this.total; },
                rp(n) { return 'Rp ' + Number(n).toLocaleString('id-ID'); },
                async pay() {
                    this.error = '';
                    if (!this.cart.length) { this.error = 'Keranjang kosong.'; return; }
                    this.loading = true;
                    try {
                        const r = await fetch(window.POS_URL, {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': window.POS_CSRF },
                            body: JSON.stringify({
                                items: this.cart.map(c => ({ id: c.id, qty: c.qty })),
                                payment_method: this.method,
                                paid: this.method === 'tunai' ? (+this.paid || 0) : this.total,
                                discount: +this.discount || 0,
                            }),
                        });
                        const d = await r.json();
                        if (r.ok) window.location.href = d.redirect;
                        else this.error = d.message || 'Transaksi gagal.';
                    } catch (e) { this.error = 'Gagal terhubung ke server.'; }
                    this.loading = false;
                },
            };
        }
    </script>

    <div x-data="pos(window.POS_PRODUCTS)" class="grid md:grid-cols-3 gap-4">
        <div class="md:col-span-2">
            <input x-model="q" @keydown.enter.prevent="addByCode()" placeholder="Cari nama / ketik kode atau scan barcode lalu Enter" class="input mb-3" autofocus>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                <template x-for="p in filtered" :key="p.id">
                    <button type="button" @click="add(p)" class="card text-left" :disabled="p.stock <= 0" :style="p.stock <= 0 ? 'opacity:.5' : ''">
                        <div class="font-semibold" x-text="p.name"></div>
                        <div class="text-xs text-gray-500" x-text="p.code + ' | stok ' + p.stock"></div>
                        <div class="text-green-700 font-bold" x-text="rp(p.price)"></div>
                    </button>
                </template>
            </div>
        </div>

        <div class="card h-fit">
            <h2 class="font-bold mb-2">Keranjang</h2>
            <template x-for="(c, i) in cart" :key="c.id">
                <div class="flex items-center gap-2 mb-2">
                    <div class="flex-1 text-sm" x-text="c.name"></div>
                    <input type="number" min="1" :max="c.stock" x-model.number="c.qty" class="input" style="width:4rem">
                    <div class="text-sm w-24 text-right" x-text="rp(c.price * c.qty)"></div>
                    <button type="button" @click="remove(i)" class="btn btn-red" style="padding:.2rem .5rem">x</button>
                </div>
            </template>
            <div x-show="!cart.length" class="text-sm text-gray-500 mb-2">Belum ada barang.</div>
            <hr class="my-2">

            <div class="flex justify-between"><span>Subtotal</span><span x-text="rp(subtotal)"></span></div>
            <div class="my-2"><label class="text-sm">Diskon (Rp, maks. {{ $maxDiscount }}%)</label>
                <input type="number" min="0" x-model.number="discount" class="input"></div>
            <div class="flex justify-between font-bold text-lg"><span>Total</span><span x-text="rp(total)"></span></div>

            <div class="my-2"><label class="text-sm">Metode bayar</label>
                <select x-model="method" class="input">
                    <option value="tunai">Tunai</option><option value="transfer">Transfer</option><option value="qris">QRIS</option>
                </select></div>
            <div class="my-2" x-show="method === 'tunai'"><label class="text-sm">Uang diterima</label>
                <input type="number" min="0" x-model.number="paid" class="input">
                <div class="text-sm mt-1">Kembalian: <b x-text="rp(Math.max(change,0))"></b></div></div>

            <div class="text-red-700 text-sm mb-2" x-text="error"></div>
            <button type="button" class="btn w-full" @click="pay()" :disabled="loading" x-text="loading ? 'Memproses...' : 'Bayar'"></button>
        </div>
    </div>
</x-toko-layout>