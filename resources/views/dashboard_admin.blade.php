<div class="row">
    <div class="col-xl-6 col-md-6">
        <div class="card bg-primary text-white mb-4">
            <div class="card-body d-flex align-items-center">
                <i class="fas fa-users fa-2x mr-3"></i> <!-- Icon -->
                <div>
                    <div class="text-white lead">Users Aktif</div>
                    <div class="text-white lead">{{$totalUsersActive}} Akun</div> <!-- Numeric value -->
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="{{route('user.index')}}">View Details</a>
                <div class="small text-white">
                    <i class="fas fa-angle-right"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-6 col-md-6">
        <div class="card bg-danger text-white mb-4">
            <div class="card-body d-flex align-items-center">
                <i class="fas fa-users-slash fa-2x mr-3"></i> <!-- Icon -->
                <div>
                    <div class="text-white lead">User Non Aktif</div>
                    <div class="text-white lead">{{$totalUsersInActive}} Akun</div> <!-- Numeric value -->
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="{{route('user.index')}}">View Details</a>
                <div class="small text-white">
                    <i class="fas fa-angle-right"></i>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="row">
    <div class="col-xl-3 col-md-6">
        <div class="card bg-success text-white mb-4">
            <div class="card-body d-flex align-items-center">
                <i class="fas fa-check fa-2x mr-3"></i> <!-- Icon -->
                <div>
                    <div class="text-white lead">Disetujui</div>
                    <div class="text-white lead">{{$disetujuiCount}} Customer</div> <!-- Numeric value -->
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="{{route('verifikasi.index')}}">View Details</a>
                <div class="small text-white">
                    <i class="fas fa-angle-right"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-dark text-white mb-4">
            <div class="card-body d-flex align-items-center">
                <i class="fas fa-sync-alt fa-2x mr-3"></i> <!-- Icon -->
                <div>
                    <div class="text-white lead">Pending</div>
                    <div class="text-white lead">{{$pendingCount}} Customer</div> <!-- Numeric value -->
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="{{route('verifikasi.index')}}">View Details</a>
                <div class="small text-white">
                    <i class="fas fa-angle-right"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-secondary text-white mb-4">
            <div class="card-body d-flex align-items-center">
                <i class="fas fa-undo-alt fa-2x mr-3"></i> <!-- Icon -->
                <div>
                    <div class="text-white lead">Dibatalkan</div>
                    <div class="text-white lead">{{$batalCount}} Customer</div> <!-- Numeric value -->
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="{{route('verifikasi.index')}}">View Details</a>
                <div class="small text-white">
                    <i class="fas fa-angle-right"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-danger text-white mb-4">
            <div class="card-body d-flex align-items-center">
                <i class="fas fa-times-circle fa-2x mr-3"></i> <!-- Icon -->
                <div>
                    <div class="text-white lead">Ditolak</div>
                    <div class="text-white lead">{{$ditolakCount}} Customer</div> <!-- Numeric value -->
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="{{route('verifikasi.index')}}">View Details</a>
                <div class="small text-white">
                    <i class="fas fa-angle-right"></i>
                </div>
            </div>
        </div>
    </div>
</div>