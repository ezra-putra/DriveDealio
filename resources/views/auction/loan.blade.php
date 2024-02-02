@extends('layout.main')
@section('content')

<h3>Loan</h3>
<div class="col-md-12" style="padding: 3vh;">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body col-md-12">
                    <h4>Loan Simulation</h4>
                    <form id="kreditForm">
                        <div class="col-md-12">
                            <label class="form-label" for="username">Vehicle Price</label>
                            <div class="col-md-12 mb-2">
                                <input type="number" class="form-control" id="hargaMotor"
                                    placeholder="Enter vehicle price" value="{{ $vehicle[0]->current_price }}" required/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label class="form-label" for="username">Down Payment (%)</label>
                                <div class="col-md-12 mb-2">
                                    <input type="number" class="form-control" id="uangMukaPersen" oninput="updateUangMuka()"
                                        placeholder="Enter down payment" required/>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <label class="form-label" for="username">Down Payment (Rp.)</label>
                                <div class="col-md-12 mb-2">
                                    <input type="number" class="form-control" id="uangMukaNominal"/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label" for="username">Interest per month (%)</label>
                                <div class="col-md-12 mb-2">
                                    <input type="number" class="form-control" id="sukuBunga" value="1.1" required/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="username">Loan Duration</label>
                                <div class="col-md-12 mb-2">
                                    <input type="number" class="form-control" id="jangkaWaktu" required/>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary" onclick="hitungKredit()">Hitung Kredit</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-body col-md-12">
                    <div id="hasilKredit">
                        <h5>Loan Calculation Result</h5>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Tenor</th>
                                    <th>Angsuran</th>
                                    <th>Total Angsuran</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                <!-- Tabel akan ditampilkan di sini -->
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        function formatRupiah(angka) {
            var reverse = angka.toString().split('').reverse().join('');
            var ribuan = reverse.match(/\d{1,3}/g);
            var formatted = ribuan.join('.').split('').reverse().join('');
            return 'Rp ' + formatted;
        }

        function updateUangMuka() {
            var hargaMotor = parseFloat($('#hargaMotor').val());
            var uangMukaPersen = parseFloat($('#uangMukaPersen').val());

            // Validasi uang muka (30% - 60% dari harga motor)
            var minUangMuka = 0.1 * hargaMotor;
            var maxUangMuka = 0.8 * hargaMotor;

            if (uangMukaPersen < 10 || uangMukaPersen > 80) {
                alert('Persentase uang muka harus antara 10% dan 80% dari harga motor.');
                return;
            }

            var uangMukaNominal = (uangMukaPersen / 100) * hargaMotor;
            $('#uangMukaNominal').val(uangMukaNominal.toFixed(2));
        }

        function hitungKredit() {
            var hargaMotor = parseFloat($('#hargaMotor').val());
    var uangMukaPersen = parseFloat($('#uangMukaPersen').val());
    var sukuBunga = parseFloat($('#sukuBunga').val()) / 100 || 0.011; // default 1.1%
    var tenorList = [12, 24, 36, 48, 60]; // Daftar tenor yang ingin ditampilkan (dalam bulan)

    // Validasi uang muka (30% - 60% dari harga motor)
    var minUangMuka = 0.1 * hargaMotor;
    var maxUangMuka = 0.8 * hargaMotor;

    if (uangMukaPersen < 10 || uangMukaPersen > 80) {
        alert('Persentase uang muka harus antara 10% dan 80% dari harga motor.');
        return;
    }

    var uangMuka = (uangMukaPersen / 100) * hargaMotor;
    var pokokKredit = hargaMotor - uangMuka;
    var tabelBody = '';

    for (var i = 1; i < tenorList.length; i++) {
        var jangkaWaktu = tenorList[i];
        var angsuranPokok = pokokKredit / jangkaWaktu;
        var totalAngsuran = 0;

        tabelBody += '<tr>' +
            '<td>' + jangkaWaktu + ' Bulan</td>';

        for (var j = 1; j <= jangkaWaktu; j++) {
            var angsuranBunga = (pokokKredit * sukuBunga) / jangkaWaktu;
            var totalPembayaran = angsuranPokok + angsuranBunga;
            totalAngsuran += totalPembayaran;
            pokokKredit -= angsuranPokok;
        }

        tabelBody += '<td>' + formatRupiah(angsuranPokok.toFixed(2)) + '</td>' +
            '<td>' + formatRupiah(totalAngsuran.toFixed(2)) + '</td>' +
            '</tr>';
    }

    var hasilKredit = 'Loan Calculation Result';
    $('#tableBody').html(tabelBody);
        }
    </script>
@endsection
