$(document).ready(function () {
    var jcropApi;

    $('#image-input').change(function () {
        var input = this;
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#preview').attr('src', e.target.result);
                $('#preview').Jcrop({
                    aspectRatio: 1,
                    boxWidth: 500,
                    onSelect: updateCoords
                }, function () {
                    jcropApi = this;
                });
            };

            reader.readAsDataURL(input.files[0]);
        }
    });

    function updateCoords(c) {
        $('#x').val(c.x);
        $('#y').val(c.y);
        $('#width').val(c.w);
        $('#height').val(c.h);
    }

    $('#apply-crop-button').click(function () {
        // Get the cropping coordinates
        var cropData = jcropApi.tellSelect();

        // Create a canvas element and draw the cropped image on it
        var canvas = document.getElementById('cropped-preview');
        var ctx = canvas.getContext('2d');
        var img = document.getElementById('preview');

        canvas.width = cropData.w;
        canvas.height = cropData.h;

        ctx.drawImage(img, cropData.x, cropData.y, cropData.w, cropData.h, 0, 0, cropData.w, cropData.h);

        // Show the canvas and hide the image preview
        $('#preview').hide();
        $('#cropped-preview').show();
    });

    $('#upload-button').click(function () {
        // Get the data URL of the cropped image from the canvas
        var croppedDataURL = $('#cropped-preview')[0].toDataURL();

        // Convert the data URL to a Blob
        var blob = dataURItoBlob(croppedDataURL);

        // Create a FormData object and append the Blob
        var formData = new FormData();
        formData.append('croppedImage', blob);

        // Send AJAX request to upload.php
        $.ajax({
            type: 'POST',
            url: 'upload.php',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                alert('Cropped image uploaded successfully! File name: ' + response);
            },
            error: function (xhr, status, error) {
                alert('Error uploading cropped image: ' + error);
            }
        });
    });

    // Function to convert data URL to Blob
    function dataURItoBlob(dataURI) {
        var byteString = atob(dataURI.split(',')[1]);
        var ab = new ArrayBuffer(byteString.length);
        var ia = new Uint8Array(ab);
        for (var i = 0; i < byteString.length; i++) {
            ia[i] = byteString.charCodeAt(i);
        }
        return new Blob([ab], { type: 'image/png' });
    }
});
