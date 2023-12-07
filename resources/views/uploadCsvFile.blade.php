@extends('layouts.main')

@section('upload-csv-file')
    <aside>
        <!-- Attached Leftlist Here-->
        @include('layouts/leftlist')

        <div class="col-md-10 main-section">
            <!-- Display success message if available in the session -->
            @if (session('success'))
                <div class="alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Display error message if available in the session -->
            @if (session('error'))
                <div class="alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Main content section -->
            <section>
                <h3 style="font-size:16px; font-weight:bold; color:#1C5978; text-align:left;margin-left:0px;">Upload Csv</h3>
                <hr style="margin:0px; width:600px; margin-bottom:10px" />
                <div
                    style=" background:#F3F1F1;border:1px solid silver; font: bold 13px/13px arial ;padding:5px 0px 5px 15px ">
                    Upload Csv File</div>
                <div>
                    <!-- Form for uploading Csv File -->
                    <form id="uploadForm" method="post" enctype="multipart/form-data" action="">
                        @csrf
                        <table class="addpage-table">
                            <tr>
                                <td>Upload Csv</td>
                                <td>
                                    <input type="file" name="csv_file" id="csvFile" accept=".csv">
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td colspan="2">
                                    <button class="srchbtn" type="submit" onclick="setAction('pdf')">Download Pdf</button>
                                    <button class="srchbtn" type="submit" onclick="setAction('images')">Download Images</button>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </section>
        </div>
    </aside>
@endsection
@section('script')
{{-- script use for take action by clicking button --}}
<script>
    function setAction(type) {
        var form = document.getElementById('uploadForm');
        if (type === 'pdf') {
            form.action = '{{ url("/generate-pdf") }}';
            form.submit();
        } else if (type === 'images') {
            form.action = '{{ url("/generate-zip") }}';
            form.submit();
        }
    }
</script>

@endsection
