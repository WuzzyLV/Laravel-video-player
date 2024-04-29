<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Upload a video') }}
        </h2>
    </x-slot>
    @if ($errors->any())
        <div class="notification is-danger is-light">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="flex my-3 justify-center">
        <div class="card w-2/3 mx-12 bg-gray-800 shadow-xl">
            <div class="card-body">
                <h2 class="card-title flex justify-between">
                    <div>
                        Fill out the form below to upload a video
                    </div>
                </h2>
                <form action="{{ route('uploads.store') }}" method="POST" enctype="multipart/form-data"
                      class="card-body p-3 flex flex-col" id="upload">
                    @csrf
                    <input type="text" name="title" placeholder="Title here" required
                           class="input input-bordered w-full  my-2">
                    <input type="text" name="description" placeholder="Write your description here" required
                           class="textarea textarea-bordered my-2 w-full">
                    <div class="form-control">
                        <label class="label cursor-pointer justify-start">
                            <input type="checkbox" name="is_public" checked="checked" class="checkbox"/>
                            <span class="label-text text-lg pl-4">Public</span>
                        </label>
                        <input type="file" name="file_upload" accept=".mp4" required
                               class="file-input file-input-bordered w-full my-2">
                    </div>
                    <button type="submit" class="btn my-2" id="upload-btn">Upload</button>
                </form>
            </div>
        </div>

        <script>
            const form = document.getElementById('upload'); // Select the form element
            const fileInput = document.querySelector('input[type="file"]'); // Select the file input
            const uploadButton = document.getElementById('upload-btn'); // Select the upload button

            form.addEventListener('submit', (event) => {
                const formData = new FormData(form); // Create a FormData object to hold the file

                const xhr = new XMLHttpRequest();

                // Track upload progress
                xhr.upload.addEventListener('progress', (event) => {
                    if (event.lengthComputable) {
                        const percentComplete = (event.loaded / event.total) * 100;
                        uploadButton.innerText = 'Uploading... ' + percentComplete.toFixed(2) + '%';
                        if (percentComplete === 100) {
                            uploadButton.innerText = 'Finishing up...';
                        }
                    }
                });

                // Optional: Handle successful upload
                xhr.addEventListener('load', () => {
                    console.log('Upload successful');
                    setTimeout(() => {
                        uploadButton.innerText = 'Upload';
                    }, 3000);
                });

                // Optional: Handle upload errors
                xhr.addEventListener('error', () => {
                    uploadButton.innerText = 'Upload failed';
                });

                xhr.open('POST', form.action); // Use the form's action URL
                // xhr.send(formData);
            });

        </script>

</x-app-layout>
