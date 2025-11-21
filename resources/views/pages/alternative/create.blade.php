@extends('layouts.auth-v1.main')

@push('page_css')
<style>
     .gallery-box {
        width: 140px;
        height: 140px;
        border: 2px dashed #c3c3c3;
        border-radius: 10px;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        overflow: hidden;
        background: #f8f9fa;
        position: relative;
    }
    .gallery-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .plus-icon {
        font-size: 32px;
    }
    .file-input {
        display: none;
    }
    .delete-btn {
        position: absolute;
        top: 3px;
        right: 3px;
        background: rgba(0,0,0,0.6);
        color: #fff;
        border-radius: 50%;
        width: 22px;
        height: 22px;
        font-size: 14px;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
    }
    .delete-btn:hover {
        background: red;
    }
</style>
@endpush
@section('content')
    <div class="card">
        <div class="card-header mb-4 border-bottom">
            <h4 class="m-0 p-0">Tambah Alternatif Wisata</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('spk/destinasi/alternative.store') }}" method="POST" enctype="multipart/form-data" id="alternativeForm">
            @csrf
                <h5 class="card-title text-white p-2 bg-info rounded-top ps-3">Detail Alternatif Wisata</h5>
                <div class="card-text mb-4 border-bottom">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nama-wisata" class="form-label">Nama Wisata</label>
                                <input type="text" class="form-control form-control-md" id="nama-wisata" name="name" placeholder="Nama Wisata" value="{{ old('name') }}" required />
                            </div>
                            <div class="mb-3">
                                <label for="harga-wisata" class="form-label">Harga</label>
                                <input type="number" class="form-control form-control-md" id="harga-wisata" name="harga" placeholder="Tarif Wisata" value="{{ old('harga') }}" required />
                            </div>
                            <div class="mb-3">
                                <label for="waktu_operasional" class="form-label">Waktu Operasional</label>
                                <input type="text" class="form-control form-control-md" id="waktu_operasional" name="waktu_operasional" placeholder="waktu operasional destinasi" value="{{ old('waktu_operasional') }}" required />
                            </div>
                            <div class="mb-3">
                                <label for="alamat-wisata" class="form-label">Alamat</label>
                                <textarea name="alamat" class="form-control form-control-md" id="alamat-wisata" cols="10" rows="3" placeholder="Alamat lokasi wisata" required>{{ old('alamat') }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="aksesibilitas-wisata" class="form-label">Aksesibilitas</label>
                                <textarea name="aksesibilitas" class="form-control form-control-md" id="aksesibilitas-wisata" cols="10" rows="1" placeholder="rincikan akses ke tempat wisata" required>{{ old('aksesibilitas') }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="kategori-wisata" class="form-label">Kategori</label>
                                <select class="form-select form-control" id="kategori-wisata" aria-label="Default select example" name="travel_category_id" required>
                                    <option selected disabled>-- Pilih Kategori --</option>
                                    @foreach ($data as $item)
                                    <option value="{{ $item->id }}" {{ old('travel_category_id') == $item->id ? 'selected' : '' }}>{{ $item->name ?? '-' }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="fasilitas" class="form-label">Fasilitas</label>
                                <textarea name="fasilitas" class="form-control form-control-md" id="fasilitas" cols="30" rows="2" placeholder="Fasilitas Yang Disediakan Pada Objek Wisata" required>{{ old('fasilitas') }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="deskripsi-wisata" class="form-label">Deskripsi</label>
                                <textarea name="deskripsi" class="form-control form-control-md" id="deskripsi-wisata" cols="30" rows="6" placeholder="Deskripsi tentang objek wisata" required>{{ old('deskripsi') }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="foto-wisata" class="form-label">Foto Utama</label>
                                <input type="file" class="form-control form-control-md" id="foto-wisata" name="foto" onchange="previewImage(this)"/>
                                <img id="preview-image" src="" alt="" class="img-fluid mt-4" width="250" height="250" style="display: none;">
                                {{-- preview image --}}
                                @error('foto')
                                <div class="small text-danger fst-italic">
                                    * {{ $message ?? '' }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12 mb-3 mt-4 p-4 border border-1 border-info rounded bg-label-secondary">
                            {{-- foto multiple input --}}
                            <h5 class="text-white p-2 bg-secondary rounded-top ps-3">Foto Lainnya</h5>

                            <div id="gallery-wrapper" class="d-flex flex-wrap gap-3 justify-content-center">
                                <!-- Kotak kosong pertama -->
                                <div class="gallery-box empty-box shadow-sm" onclick="triggerEmptyBox()">
                                    <span class="text-muted plus-icon">+</span>
                                    <input type="file" class="file-input" accept="image/*" multiple onchange="handleMultipleUpload(event)">
                                </div>
                            </div>

                            <input type="file" id="other_image_input" name="other_images[]" multiple hidden>
                            {{-- foto multiple input --}}
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="maps-lokasi" class="form-label">
                                    Lokasi Wisata
                                    <br>
                                    <span class="text-danger small fst-italic text-lowercase">*Tandai Lokasi objek wisata pada map dibawah ini</span>
                                </label>
                                <input type="hidden" class="form-control form-control-md" id="maps-lokasi" name="maps_lokasi" placeholder="Titik Tepat Lokasi Wisata Berada" value="{{ old('maps_lokasi') }}" required />
                                <div id="map" style="width: 100%; height: 300px;"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <h5 class="card-title text-white p-2 bg-danger rounded-top ps-3">Penilaian Alternatif Wisata</h5>
                <div class="card-text mb-4">
                    <div class="row">
                        @foreach ($criterias as $index => $item)
                            <input type="hidden" name="criteria_id[]" value="{{ $item->id }}">
                            <div class="col-md-6 mb-3">
                                <label for="sub-criteria-{{ $item->name }}" class="form-label">{{ $item->name ?? '-' }}</label>
                                <select class="form-select form-control" id="sub-criteria-{{ $item->id }}" aria-label="Default select example" name="sub_criteria_id[]" required>
                                    <option selected disabled>-- Pilih --</option>
                                    @foreach ($item->subCriterias as $key => $opt)
                                        {{-- <option value="{{ $opt->id }}" {{ !empty(old('sub_criteria_id')) ? (old('sub_criteria_id')[$index] == $opt->id ? 'selected' : '') : '' }}>{{ $opt->label ?? '-' }}</option> --}}
                                        <option value="{{ $opt->id }}" {{ old('sub_criteria_id.'.$index) == $opt->id ? 'selected' : '' }}>{{ $opt->label ?? '-' }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endforeach
                        <div class="col-md-12 mt-4 border-top">
                            <div class="d-flex justify-content-center mt-4">
                                <a href="{{ route('spk/destinasi/alternative.index') }}" class="btn btn-md btn-danger me-2"><i class="bx bx-left-arrow"></i> Kembali</a>
                                <button type="submit" class="btn btn-md btn-success"><i class="bx bx-file"></i> Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('script_page')
    <script>
        let galleryFiles = []; // menampung semua File gambar

        function triggerEmptyBox() {
            document.querySelector(".empty-box .file-input").click();
        }

        function handleMultipleUpload(event) {
            const files = Array.from(event.target.files);

            files.forEach(file => {
                if (file.type.startsWith("image/")) {
                    const isValidImage = validationImage(file);
                    if (isValidImage.status) {
                        galleryFiles.push(file);
                    }else{
                        notif.error(isValidImage.msg);
                    }
                }else{
                    notif.error('File yang dipilih harus gambar (jpg/png)');
                }
            });

            redrawGallery();
        }

        function redrawGallery() {
            const wrapper = document.getElementById("gallery-wrapper");
            wrapper.innerHTML = ""; // reset

            // render semua gambar yang sudah dipilih
            galleryFiles.forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const box = document.createElement("div");
                    box.classList.add("gallery-box", "shadow-sm");

                    box.innerHTML = `
                        <img src="${e.target.result}">
                        <button class="delete-btn" onclick="removeImage(${index})">×</button>
                    `;

                    wrapper.appendChild(box);
                };
                reader.readAsDataURL(file);
            });

            // Tambahkan kotak kosong 1x saja
            const emptyBox = document.createElement("div");
            emptyBox.classList.add("gallery-box", "empty-box", "shadow-sm");
            emptyBox.setAttribute("onclick", "triggerEmptyBox()");
            emptyBox.innerHTML = `
                <span class="text-muted plus-icon">+</span>
                <input type="file" class="file-input" accept="image/*" multiple onchange="handleMultipleUpload(event)">
            `;

            wrapper.appendChild(emptyBox);
        }

        function removeImage(index) {
            galleryFiles.splice(index, 1);
            redrawGallery();
        }


        // inject foto ketika submit form
        const form = document.getElementById('alternativeForm');
        const inputFileImages = document.getElementById('other_image_input');

        form.addEventListener('submit', function(e){
            const data = new DataTransfer();

            galleryFiles.forEach((file, index) => {
                if(file){
                    data.items.add(file);
                }
            });

            inputFileImages.files = data.files;
        });
    </script>
@endpush