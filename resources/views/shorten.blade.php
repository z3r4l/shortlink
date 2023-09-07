<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Short Link Nextup</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-5">
        <h1>ShortLink</h1>
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
        <div class="card">
            <div class="card-header">
                <form action="{{ route('generate.shorten.link.post') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-lg-4 col-12">
                            <label for="title" class="form-label fw-bold">Title</label>
                            <div class="input-group mb-3">
                                <input type="text" name="title" class="form-control" placeholder="Masukan Title">
                            </div>
                            @error('title')
                            <p class="m-0 p-0 text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-lg-4 col-12">
                            <label for="code" class="form-label fw-bold">Pendekan URL</label>
                            <div class="input-group">
                                <span class="input-group-text text-secondary" id="basic-addon3">bit.nextup.fun/</span>
                                <input type="text" name="code" class="form-control" id="basic-url"
                                    aria-describedby="basic-addon3 basic-addon4" placeholder="HMTI-UIS">
                            </div>
                            <div class="form-text m-0" id="basic-addon4">
                                <p class="ms-1">Masukan Link Pendek Yang Di Inginkan</p>
                            </div>
                        </div>
                        <div class="col-lg-4 col-12">
                            <label for="link" class="form-label fw-bold">Link Website</label>
                            <div class="input-group mb-3">
                                <input type="text" name="link" class="form-control" placeholder="Masukan Link">
                                <div class="input-group-addon">
                                    <button class="btn btn-success ms-2">Buat Link</button>
                                </div>
                            </div>
                            @error('link')
                            <p class="m-0 p-0 text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                </form>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12 col-12 table-responsive-sm table-responsive-md">
                        <table class="table table-bordered table-responsive-sm">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>QR</th>
                                    <th>Title</th>
                                    <th>Short Link</th>
                                    <th>Link</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($shortLinks as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="text-center">
                                        <img src="{{ asset('storage/qrcodes/' . $item->qrcode) }}" alt="QR Code" width="100" height="100">
                                        <br>
                                        <a href="{{ route('qr.download', ['filename' => $item->qrcode]) }}">Download QR</a>
                                    </td>
                                    <td>{{ $item->title }}</td>
                                    <td>
                                        <a href="{{ route('shorten.link', $item->code) }}" target="__blank">{{
                                            route('shorten.link',
                                            $item->code) }}</a>
                                    </td>
                                    <td>
                                        {{ $item->link }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa" crossorigin="anonymous">
    </script>
</body>

</html>