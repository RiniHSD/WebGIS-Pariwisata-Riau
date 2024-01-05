<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tabel Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.3/css/dataTables.bootstrap5.min.css">
    style>
    .container {
    padding-top: 75px;
    }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-dark fixed-top" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><i class="fa-solid fa-location-dot"></i> Peta Lokasi Objek</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">

                    <?php if (auth()->loggedIn()) : ?>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="<?= base_url('home/input') ?>"><i class="fa-solid fa-circle-plus"></i> Input</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="#"><i class="fa-solid fa-table"></i> Tabel</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('home/peta') ?>"><i class="fa-regular fa-map"></i> Peta</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#infoModal"><i class="fa-solid fa-circle-user"></i> Info</a>
                        <li class="nav-item">
                            <a class="nav-link text-danger" href="<?= base_url('logout') ?>"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
                        </li>
                    <?php else : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="#"><i class="fa-regular fa-map"></i> Peta</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-info" href="<?= base_url('login') ?>"><i class="fa-solid fa-right-to-bracket"></i> Login</a>
                        <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container my-4">

        <!-- Flashdata -->
        <?php if (session()->getFlashdata('message')) : ?>
            <div class="alert alert-<?= session()->getFlashdata('message')['type'] ?> alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('message')['content'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-header">
                <h2><i class="fa-solid fa-table"></i> Tabel Data Objek</h2>
            </div>
            <div class="card-body">
                <table class="table table-striped table-bordered" id="dataobjek">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Latitude</th>
                            <th>Longitude</th>
                            <th>Foto</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($dataobjek as $d) : ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td><?= $d['nama'] ?></td>
                                <td><?= $d['deskripsi'] ?></td>
                                <td><?= $d['latitude'] ?></td>
                                <td><?= $d['longitude'] ?></td>
                                <td>
                                    <img src="<?= base_url('upload/foto/'), '/', $d['foto'] ?>" width="150" alt="Tidak ada foto">
                                </td>
                                <td class="text-center">
                                    <a class="btn btn-warning" href="<?= base_url('home/edit_data/') . $d['id'] ?>" role="button"><i class="fa-regular fa-pen-to-square"></i></a>
                                    <a class="btn btn-danger" href="<?= base_url('home/hapus_data/') . $d['id'] ?>" role="button" onclick="return confirm('Yakin akan menghapus data <?= $d['nama'] ?> ini?')"><i class="fa-solid fa-trash-can"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- Modal -->
    <div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel"><i class="fa-solid fa-circle-info"></i> User Info</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped table-bordered">
                        <tr>
                            <th>Username</th>
                            <td><?= auth()->user()->username ?></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td><?= auth()->user()->email ?></td>
                        </tr>
                        <tr>
                            <th>Registered at</th>
                            <td><?= auth()->user()->created_at ?></td>
                        </tr>

                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.3/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#dataobjek').DataTable();
        });
    </script>
</body>

</html>