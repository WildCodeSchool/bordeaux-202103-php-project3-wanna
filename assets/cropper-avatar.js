import Cropper from 'cropperjs/dist/cropper';

function getRoundedCanvas(sourceCanvas) {
    const canvas = document.createElement('canvas');
    const context = canvas.getContext('2d');
    const width = sourceCanvas.width;
    const height = sourceCanvas.height;

    canvas.width = width;
    canvas.height = height;
    context.imageSmoothingEnabled = true;
    context.drawImage(sourceCanvas, 0, 0, width, height);
    context.globalCompositeOperation = 'destination-in';
    context.beginPath();
    context.arc(width / 2, height / 2, Math.min(width, height) / 2, 0, 2 * Math.PI, true);
    context.fill();
    return canvas;
}



// get the filename
document.querySelector('.custom-file-input').addEventListener('change',function(e){
    let fileName = document.getElementById("avatar_image_file").files[0].name;
    let nextSibling = e.target.nextElementSibling;
    nextSibling.innerText = fileName;
});

window.addEventListener('DOMContentLoaded', () => {
    const image = document.getElementById('image-avatar');
    const button = document.getElementById('button');

    let croppable = false;
    const cropper = new Cropper(image, {
        aspectRatio: 1,
        viewMode: 1,
        ready: function () {
            croppable = true;
        },
    });

    button.onclick = () => {
        let croppedCanvas;
        let roundedCanvas;
        let roundedImage;
        if (!croppable) {
            return;
        }

        croppedCanvas = cropper.getCroppedCanvas();
        roundedCanvas = getRoundedCanvas(croppedCanvas);

        const result = document.getElementsByClassName('image-cropping');
        const formData = new FormData();
        formData.append('avatar', roundedCanvas.toDataURL());

        const options = {
            method: 'POST',
            body: formData,
        };
        fetch(result[0].dataset.path, options)
            .then(response => console.log(response))
            .then(data => window.location = '/dashboard/index')

    }
})
