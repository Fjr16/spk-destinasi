@extends('layouts.auth-v1.main')

@section('content')
  <div class="row">
      <div class="col-lg-8 mb-4 order-0">
        <div class="card mb-4">
          <div class="d-flex align-items-end row">
            <div class="col-sm-7">
              <div class="card-body">
                <h5 class="card-title text-primary">Selamat Datang Admin! 🎉</h5>
                <p class="mb-4">
                  Profesional, Berintegritas, Responsif, dan Fokus Pada Keselamatan Pasien.
                </p>

                <a href="javascript:;" class="btn btn-sm btn-outline-primary">View Badges</a>
                <a href="javascript:;" class="btn btn-sm btn-primary">View Badges</a>
              </div>
            </div>
            <div class="col-sm-5 text-center text-sm-left">
              <div class="card-body pb-0 px-0 px-md-4">
                <img
                  src="../assets/img/illustrations/medical-illustration-doctor.png"
                  height="140"
                  alt="View Badge User"
                  data-app-dark-img="illustrations/medical-illustration-doctor.png"
                  data-app-light-img="illustrations/medical-illustration-doctor.png"
                />
              </div>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="row row-bordered g-0">
            <div class="col-md-12">
              <h5 class="card-header m-0 me-2 pb-3">Pasien</h5>
              <div id="totalRevenueChart" class="px-2"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-4 order-1 mb-4">
          <div class="card h-100">
              <div class="card-header d-flex align-items-center justify-content-between pb-0">
                <div class="card-title mb-0">
                  <h5 class="m-0 me-2">Kunjungan Poli</h5>
                  <small class="text-muted">Maret 2023 - September 2023</small>
                </div>
                <div class="dropdown">
                  <button
                    class="btn p-0"
                    type="button"
                    id="orederStatistics"
                    data-bs-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false"
                  >
                    <i class="bx bx-dots-vertical-rounded"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-end" aria-labelledby="orederStatistics">
                    <a class="dropdown-item" href="javascript:void(0);">Select All</a>
                    <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                    <a class="dropdown-item" href="javascript:void(0);">Share</a>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                  <div class="d-flex flex-column align-items-center gap-1">
                    <h2 class="mb-2">2,258</h2>
                    <span>Total Kunjungan</span>
                  </div>
                  <div id="orderStatisticsChart"></div>
                </div>
                <ul class="p-0 m-0">
                  <li class="d-flex mb-4 pb-1">
                    <div class="avatar flex-shrink-0 me-3">
                      <span class="avatar-initial rounded bg-label-primary"
                        ><i class="bx bx-clinic"></i
                      ></span>
                    </div>
                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                      <div class="me-2">
                        <h6 class="mb-0">Bedah Umum</h6>
                        <small class="text-muted">Maret - September</small>
                      </div>
                      <div class="user-progress">
                        <small class="fw-semibold">85 Pasien</small>
                      </div>
                    </div>
                  </li>
                  <li class="d-flex mb-4 pb-1">
                    <div class="avatar flex-shrink-0 me-3">
                      <span class="avatar-initial rounded bg-label-success"><i class="bx bx-health"></i></span>
                    </div>
                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                      <div class="me-2">
                        <h6 class="mb-0">Bedah Onkologi</h6>
                        <small class="text-muted">Maret - September</small>
                      </div>
                      <div class="user-progress">
                        <small class="fw-semibold">15 Pasien</small>
                      </div>
                    </div>
                  </li>
                  <li class="d-flex mb-4 pb-1">
                    <div class="avatar flex-shrink-0 me-3">
                      <span class="avatar-initial rounded bg-label-info"><i class="bx bx-bone"></i></span>
                    </div>
                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                      <div class="me-2">
                        <h6 class="mb-0">Bedah Ortopedi</h6>
                        <small class="text-muted">Maret - September</small>
                      </div>
                      <div class="user-progress">
                        <small class="fw-semibold">50 Pasien</small>
                      </div>
                    </div>
                  </li>
                  <li class="d-flex">
                    <div class="avatar flex-shrink-0 me-3">
                      <span class="avatar-initial rounded bg-label-secondary"
                        ><i class="bx bxs-bong"></i
                      ></span>
                    </div>
                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                      <div class="me-2">
                        <h6 class="mb-0">Penyakit Dalam</h6>
                        <small class="text-muted">Maret - September</small>
                      </div>
                      <div class="user-progress">
                        <small class="fw-semibold">50 Pasien</small>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
          </div>

      </div>
      <!-- Total Revenue -->
      {{-- <div class="col-12 col-lg-8 order-2 order-md-3 order-lg-2 mb-4">
        <div class="card">
          <div class="d-flex p-4 pt-3">
              <div class="avatar flex-shrink-0 me-3">
                <img src="{{ asset('assets/img/chart.png') }}" alt="User" />
              </div>
              <div>
                <small class="text-muted d-block">Total Total Kunjungan</small>
                <div class="d-flex align-items-center">
                  <h6 class="mb-0 me-1">2,258</h6>
                  <small class="text-success fw-semibold">
                    <i class="bx bx-chevron-up"></i>
                    32.9%
                  </small>
                </div>
              </div>
            </div>
            <div id="incomeChart"></div>
        </div>
      </div> --}}
      <!--/ Total Revenue -->
      <div class="col-12 col-md-8 col-lg-4 order-3 order-md-2">
          <div class="card">
              <div class="card-body">
                <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
                  <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                    <div class="card-title">
                      <h5 class="text-nowrap mb-2">Users Report</h5>
                      <span class="badge bg-label-warning rounded-pill">Year 2023</span>
                    </div>
                    <div class="mt-sm-auto">
                      <small class="text-success text-nowrap fw-semibold"
                        ><i class="bx bx-chevron-up"></i> 68.2%</small
                      >
                      <h3 class="mb-0">84,686k</h3>
                    </div>
                  </div>
                  <div id="profileReportChart"></div>
                </div>
              </div>
            </div>

      </div>
  </div>
@endsection
