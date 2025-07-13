@extends('layouts.guest.landing-page')

@push('page-css')
    <style>
      body {
        background: url('/assets/img/bg-old.jpg') no-repeat center center fixed;
        background-size: cover;
        color: white;
      }
      body::before {
          background-color: rgba(0, 0, 0, 0.6);
          content: "";
          position: fixed;
          top: 0;
          right: 0;
          bottom: 0;
          left: 0;
      }

      .content-wrapper {
        /* padding-top: 120px; */
        padding-bottom: 30px;
        position: relative;
        z-index: 1;
      }

      .card {
        background-color: rgba(255, 255, 255, 0.9);
        border: none;
      }

      .card-title, .card-text {
        color: #333;
      }

      .page-title {
        color: #ffffff;
        text-align: center;
        margin-bottom: 40px;
        font-size: 2.5rem;
        font-weight: 700;
        text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.5);
        letter-spacing: 1px;
        animation: fadeInDown 1s ease;
        position: relative;
      }

      .page-title::after {
        content: '';
        width: 80px;
        height: 4px;
        background-color: #ffffff;
        display: block;
        margin: 15px auto 0;
        border-radius: 10px;
      }

      @keyframes fadeInDown {
        from {
          opacity: 0;
          transform: translateY(-20px);
        }
        to {
          opacity: 1;
          transform: translateY(0);
        }
      }

      .card-img-top {
          height: 250px; /* atur sesuai kebutuhan, misal 250px */
          object-fit: cover;
          border-top-left-radius: 0.75rem;
          border-top-right-radius: 0.75rem;
      }

    .card.overlay-card {
        /* background-color: rgba(255, 255, 255, 0.15); transparan putih */
        background-color: rgba(75, 75, 75, 0.4);
        backdrop-filter: blur(10px);                /* blur latar belakang */
        -webkit-backdrop-filter: blur(10px);        /* support Safari */
        border-radius: 16px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: white;
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
    }
    .overlay-card label,
    .overlay-card h5,
    .overlay-card .form-control,
    .overlay-card .form-control::placeholder,
    .overlay-card select {
        color: white;
    }
    .overlay-card .form-control,
    .overlay-card .form-select {
        background-color: rgba(255, 255, 255, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: white;
    }


    </style>
@endpush
@section('content')

<div id="notification"></div>
<div class="container content-wrapper">
    <h2 class="page-title">Please answer the following questions !</h2>
    <div class="card overlay-card">
        <div class="card-body p-5">
            <div class="card mb-4 p-2 bg-danger">
                <small class="text-white">
                    <span class="text-warning fw-bold">Keterangan :</span> Preferensi pencarian berguna untuk mendapatkan hasil rekomendasi yang mencerminkan kehendak pengguna,
                    sebelum melakukan pencarian rekomendasi wisata terlebih dahulu pengguna wajib mengisi preferensi pencarian,
                    jika pengguna telah login maka preferensi dikaitkan dengan akun pengguna, jika tidak maka preferensi hanya dapat digunakan pada sesi ini
                </small>
            </div>
            <form action="{{ route('test.store') }}" method="POST" id="quizForm">
            @csrf
                <div class="card position-relative p-4" style="background-color: rgba(255, 255, 255, 0.1)">
                    <div class="card-body">
                        <div id="quizContainer">
                            <h5 class="mb-3" id="questionTitle"></h5>
                        </div>
                        <div id="optionsContainer" class="mb-4"></div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-between">
                            {{-- <a href="{{ route('test') }}" class="btn btn-danger">test</a> --}}
                            <button type="button" class="btn btn-danger" id="prevBtn">Prev</button>
                            <button type="button" class="btn btn-primary" id="nextBtn">Next</button>
                            <button type="submit" class="btn btn-success d-none" id="saveBtn">Save</button>
                        </div>
                    </div>

                     <!-- 🔽 Spinner overlay -->
                    <div id="loadingSpinner" class="position-absolute top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center bg-dark bg-opacity-50 d-none" style="z-index: 10;">
                        <div class="spinner-border text-light" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

<script>
    // First render
    document.addEventListener('DOMContentLoaded', function(){
        const loading = document.getElementById('loadingSpinner');
        const data = @json($dataComparison['matriks_manual_fill']);
        const options = @json($dataOptions);
        const dataMatriksAutoFill = @json($dataComparison['matriks_auto_fill']);
        let current = 0;
        const answers = Array(data.length).fill(null);

        const prevBtn = document.getElementById("prevBtn");
        const nextBtn = document.getElementById("nextBtn");
        const saveBtn = document.getElementById("saveBtn");

        function renderQuestion() {
            const title = document.getElementById("questionTitle");
            const optionsContainer = document.getElementById("optionsContainer");

            const q = data[current];
            title.innerHTML = `${current+1}. Seberapa penting <span class="fw-bold fst-italic">${q.criteria_name_first}</span> dibanding dengan <span class="fw-bold fst-italic"> ${q.criteria_name_second} </span>`;
            optionsContainer.innerHTML = '';

            options.forEach((opt, i) => {
                const checked = answers[current] == opt.nilai ? 'checked' : '';
                optionsContainer.innerHTML += `
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="answer_${current}" value="${opt.nilai}" id="opt_${current}_${i}" ${checked}>
                        <label class="form-check-label" for="opt_${current}_${i}">
                            [${opt.nilai}] ${opt.ket}
                        </label>
                    </div>
                `;
            });

            prevBtn.disabled = current === 0;
            nextBtn.classList.toggle('d-none', current === data.length - 1);
            saveBtn.classList.toggle('d-none', current !== data.length - 1);
        }

        function saveAnswer() {
            const input = document.querySelector(`input[name="answer_${current}"]:checked`);
            answers[current] = input ? input.value : null;
            data[current].nilai = input ? input.value : null;
        }

        prevBtn.addEventListener('click', () => {
            saveAnswer();
            current--;
            renderQuestion();
        });

        nextBtn.addEventListener('click', () => {
            loading.classList.remove("d-none");
            saveAnswer();
            if (answers[current] === null) {
                alert('Pilih jawaban terlebih dahulu');
                setTimeout(() => {
                    loading.classList.add("d-none");
                }, 300);
                return;
            }

            setTimeout(() => {
                current++;
                renderQuestion();

                loading.classList.add("d-none");
            }, 300);
        });

        document.getElementById('quizForm').addEventListener('submit', function (e) {
            e.preventDefault();
            saveAnswer();

            if (answers[current] === null) {
                e.preventDefault();
                alert('Pilih jawaban terlebih dahulu');
                return;
            }

            $.ajax({
                url : "{{ route('preferensi.store') }}",
                type : 'POST',
                contentType : 'application/json',
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                data : JSON.stringify({
                    matriks_manual_fill : data,
                    matriks_auto_fill : dataMatriksAutoFill
                }),
                success:function(res){
                    console.log(res);
                    if (res.status) {
                        notif.success({
                            message:res.message,
                            duration:1500
                        });

                        setTimeout(function(){
                            window.location.href = "{{ route('spk/destinasi/rekomendasi.create') }}";
                        }, 1500);
                    }else{
                        notif.error({
                            message:res.message,
                            duration:3000
                        });
                    }
                },
                error:function(xhr){
                    console.log(xhr.responseText);
                }
            })

        });

        renderQuestion();
    });
</script>
