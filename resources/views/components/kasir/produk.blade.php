<div class="modal fade" id="modal-tampil-produk" >
    <div class="modal-dialog modal-xl">
        <div class="modal-content" style="background-color:#F4B7BE; color: black">
            <div class="modal-header">
                <h4 class="modal-title">Pilih Produk</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" >
                <div class="table-responsive">
                    <table id="tabelProduk" class="table table-striped table-hover table-bordered text-center" style="width: 100%">
                        <caption>Daftar Produk</caption>
                        <thead class="text-center">
                            <tr>
                                <th>No</th>
                                <th>Nama Produk</th>
                                <th>Nama Kategori</th>
                                <th>Harga Modal</th>
                                <th>Harga Jual</th>
                                <th>Diskon</th>
                                <th>Stok</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($produks as $key => $produk)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $produk->nama_produk }}</td>
                                    <td>{{ $produk->kategori->nama_kategori }}</td>
                                    <td>{{ format_uang($produk->harga_modal) }}</td>
                                    <td>{{ format_uang($produk->harga_jual) }}</td>
                                    <td>{{ $produk->diskon }} %</td>
                                    <td>{{ $produk->stok }}</td>
                                    <td>
                                        <a href="#"
                                            @if ($produk->stok < 1 ) class="btn btn-primary btn-xs btn-flat pilih-produk disabled"
                                            @else class="btn btn-primary btn-xs btn-flat pilih-produk"
                                            @endif
                                            data-id="{{ $produk->id }}"
                                            data-nama="{{ $produk->nama_produk }}"
                                            data-harga="{{ $produk->harga_jual }}"
                                            data-diskon="{{ $produk->diskon }}"
                                            data-stok="{{ $produk->stok }}">
                                            <i class="fa fa-check-circle"></i> Pilih
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
