$(document).ready(function () {
    var cropper;

    $('#image-input').change(function () {
        $('#preview').cropper('destroy');
        var input = this;
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#preview').attr('src', e.target.result);
                // Initialize Cropper
                $('#preview').cropper({
                    aspectRatio: 1,
                    crop: function(event) {
                        // Optional: Do something when the image is cropped
                        console.log(event.detail.x);
                        console.log(event.detail.y);
                        console.log(event.detail.width);
                        console.log(event.detail.height);
                    }
                });
            };

            reader.readAsDataURL(input.files[0]);
        }
    });

    $('#apply-crop-button').click(function () {
        // Get the cropped data as a data URL
        var croppedDataUrl = $('#preview').cropper('getCroppedCanvas').toDataURL();
        // Show the cropped image preview
        $('#cropped-preview').attr('src', croppedDataUrl);
    });

    $('#upload-button').click(function () {
        // Get the cropped data as a blob
        $('#preview').cropper('getCroppedCanvas').toBlob(function (blob) {
            // Create a FormData object and append the Blob
            var purchid = localStorage.getItem("purchid");
            var formData = new FormData();
            formData.append('croppedImage', blob);
            formData.append('product_id', purchid);

            // Send AJAX request to upload.php
            $.ajax({
                type: 'POST',
                url: 'upload.php',
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    alert('Cropped image uploaded successfully! File name: ' + response);
                    $('#preview').cropper('destroy');
                },
                error: function (xhr, status, error) {
                    alert('Error uploading cropped image: ' + error);
                }
            });
        });
    });
});