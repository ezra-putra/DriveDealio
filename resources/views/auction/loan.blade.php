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
                                    placeholder="Enter vehicle price" value="{{ $order[0]->total_price }}" required/>
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
                                    <input type="number" class="form-control" id="uangMukaNominal" disabled/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label" for="username">Interest per year (%)</label>
                                <div class="col-md-12 mb-2">
                                    <input type="number" class="form-control" id="sukuBunga" value="8" required/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="jangkaWaktu">Loan Duration</label>
                                <div class="col-md-12 mb-2">
                                    <select class="form-control" id="jangkaWaktu">
                                        <option value="1">1 year</option>
                                        <option value="2">2 years</option>
                                        <option value="3">3 years</option>
                                        <option value="4">4 years</option>
                                        <option value="5">5 years</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary" onclick="hitungKredit()">Calculate Loan</button>
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
                                    <th>Year</th>
                                    <th>Monthly Installment</th>
                                    <th>Total Installment</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                <!-- Table will be populated here -->
                            </tbody>
                        </table>
                    </div>
                    <div class="row justify-content-end mt-1">
                        <div class="col-auto">
                            <form action="{{ route('loan.post', $order[0]->idorder) }}" method="POST" enctype="multipart/form-data" class="mt-1 w-100">
                                @csrf
                                <div id="hiddenInputs" style="display: none;">
                                    <!-- Hidden inputs -->
                                    <input type="hidden" id="cicilanPerbulan" name="cicilanPerbulan">
                                    <input type="hidden" id="dpRupiah" name="dpRupiah">
                                    <input type="hidden" id="bunga" name="bunga">
                                    <input type="hidden" id="jangkaWaktuInput" name="jangkaWaktuInput">
                                </div>
                                <button type="submit" class="btn btn-info">Apply Loan</button>
                            </form>
                        </div>
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

        var minUangMuka = 0.1 * hargaMotor;
        var maxUangMuka = 0.8 * hargaMotor;

        if (uangMukaPersen > 80) {
            $('#uangMukaPersen').val(0);
            $('#uangMukaNominal').val(0);
            return;
        }

        var uangMukaNominal = (uangMukaPersen / 100) * hargaMotor;
        $('#uangMukaNominal').val(uangMukaNominal.toFixed(2));
        $('#dpRupiah').val(parseInt(uangMukaNominal.toFixed(2)));
    }

    function hitungKredit() {
        var hargaMotor = parseFloat($('#hargaMotor').val());
        var uangMukaPersen = parseFloat($('#uangMukaPersen').val());
        var sukuBunga = parseFloat($('#sukuBunga').val()) / 100 || 0.08;
        var tenor = parseInt($('#jangkaWaktu').val());

        var minUangMuka = 0.1 * hargaMotor;
        var maxUangMuka = 0.8 * hargaMotor;

        if (uangMukaPersen > 80) {
            $('#uangMukaPersen').val(0);
            $('#uangMukaNominal').val(0);
            return;
        }

        var uangMuka = (uangMukaPersen / 100) * hargaMotor;
        var pokokKredit = hargaMotor - uangMuka;
        var biayaAdmin = 4500000;
        var angsuranPokok = (pokokKredit + biayaAdmin) / (tenor * 12);
        var tabelBody = '';

        for (var i = 1; i <= tenor; i++) {
            var totalPembayaranTahunan = 0;
            for (var j = 1; j <= 12; j++) {
                var angsuranBunga = (pokokKredit * sukuBunga) / 12;
                var totalPembayaran = angsuranPokok + angsuranBunga;
                totalPembayaranTahunan += totalPembayaran;
                pokokKredit -= angsuranPokok;
            }
            tabelBody += '<tr>' +
                '<td>' + i + '</td>' +
                '<td>' + formatRupiah(angsuranPokok.toFixed(2)) + '</td>' +
                '<td>' + formatRupiah(totalPembayaranTahunan.toFixed(2)) + '</td>' +
                '</tr>';
        }

        $('#tableBody').html(tabelBody);
        $('#cicilanPerbulan').val(parseInt(angsuranPokok.toFixed(2)));
        $('#bunga').val(parseInt(sukuBunga.toFixed(2) *100));
        $('#jangkaWaktuInput').val(tenor);
    }

</script>
@endsection
