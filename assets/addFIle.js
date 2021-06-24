const profileInput = document.getElementById('file_projectFile_file');
profileInput.addEventListener('change', (e) => {
    const fileName = profileInput.files[0].name;
    const nextSibling = e.target.nextElementSibling;
    nextSibling.innerText = fileName;
});
