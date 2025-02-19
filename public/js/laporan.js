$(document).ready(function () {
    let table = $("#tabelLaporanPenjualan").DataTable({
        processing: false,
        serverSide: true,
        searching: false,
        paging: false,
        info: false,
        ajax: {
            url: "/laporan/datatables/",
            data: function (d) {
                let startDate = $("#tanggal_mulai input").val();
                let endDate = $("#tanggal_akhir input").val();
                d.start_date = moment(startDate, "MM/DD/YYYY").format("YYYY-MM-DD");
                d.end_date = moment(endDate, "MM/DD/YYYY").format("YYYY-MM-DD");
            },
            dataSrc: function (json) {
                $("#totalSubtotal").html(json.totalSubtotal);
                $("#totalDiskon").html(json.totalDiskon);
                $("#totalKeuntungan").html(json.totalKeuntungan);
                return json.data;
            },

        },
        columns: [
            { data: "DT_RowIndex", name: "DT_RowIndex" },
            { data: "created_at", name: "created_at" },
            { data: "produk.nama_produk", name: "nama_produk" },
            { data: "harga_jual", name: "harga_jual" },
            { data: "jumlah", name: "jumlah" },
            { data: "subtotal", name: "subtotal" },
            { data: "diskon", name: "diskon" },
            { data: "keuntungan", name: "keuntungan" },
            { data: "penjualan.user.nama", name: "user.nama" }
        ],
    });

    $("#modal-periode-laporan").on("hide.bs.modal", function () {
        table.ajax.reload();
    });

    $("#tanggal_mulai").datetimepicker({
        format: "L",
    });

    $("#tanggal_akhir").datetimepicker({
        format: "L",
    });

    $("#ubah-periode-transaksi").click(function () {
        table.ajax.reload();
        $("#modal-periode-laporan").modal("hide");

        // Set keteranganTanggal
        let startDate = $("#tanggal_mulai input").val();
        let endDate = $("#tanggal_akhir input").val();
        let today = moment().format("MM/DD/YYYY");

        if (startDate === today && endDate === today) {
            $("#keteranganTanggal").text("Laporan Hari Ini");
        } else {
            $("#laporan").text("Laporan Tanggal");
            $("#keteranganTanggal").text(
                tanggal_indonesia(startDate, false) +
                    " - " +
                    tanggal_indonesia(endDate, false)
            );
        }

        // Update tombol PDF href
        let startDateFormatted = moment(startDate, "MM/DD/YYYY").format(
            "YYYY-MM-DD"
        );
        let endDateFormatted = moment(endDate, "MM/DD/YYYY").format(
            "YYYY-MM-DD"
        );
        let pdfUrl = $("#tombol-pdf").data("url");
        pdfUrl = pdfUrl
            .replace("startDatePlaceholder", startDateFormatted)
            .replace("endDatePlaceholder", endDateFormatted);
        $("#tombol-pdf").attr("href", pdfUrl);
    });

    // Set default keteranganTanggal saat halaman dimuat
    let today = moment().format("MM/DD/YYYY");
    $("#keteranganTanggal").text("Laporan Hari Ini");

    // Set default href for PDF button
    let todayFormatted = moment(today, "MM/DD/YYYY").format("YYYY-MM-DD");
    let defaultPdfUrl = $("#tombol-pdf").data("url");
    defaultPdfUrl = defaultPdfUrl
        .replace("startDatePlaceholder", todayFormatted)
        .replace("endDatePlaceholder", todayFormatted);
    $("#tombol-pdf").attr("href", defaultPdfUrl);
});

function tanggal_indonesia(tgl, tampil_hari = true) {
    const nama_hari = [
        "Minggu",
        "Senin",
        "Selasa",
        "Rabu",
        "Kamis",
        "Jum'at",
        "Sabtu",
    ];
    const nama_bulan = [
        "",
        "Januari",
        "Februari",
        "Maret",
        "April",
        "Mei",
        "Juni",
        "Juli",
        "Agustus",
        "September",
        "Oktober",
        "November",
        "Desember",
    ];

    console.log("Tanggal Input: ", tgl); // Debug

    const bulan = nama_bulan[parseInt(tgl.substring(0, 2))];
    const tanggal = tgl.substring(3, 5);
    const tahun = tgl.substring(6, 10);
    let text = "";

    if (tampil_hari) {
        const urutan_hari = new Date(
            tahun,
            parseInt(tgl.substring(0, 2)) - 1,
            tanggal
        ).getDay();
        const hari = nama_hari[urutan_hari];
        text += `${hari}, ${tanggal} ${bulan} ${tahun}`;
    } else {
        text += `${tanggal} ${bulan} ${tahun}`;
    }

    return text;
}
