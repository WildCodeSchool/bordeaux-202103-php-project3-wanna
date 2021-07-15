const coverInput = document.getElementById('project_coverFile_file');
coverInput.addEventListener('change', (e) => {
    const fileName = coverInput.files[0].name;
    const nextSibling = e.target.nextElementSibling;
    nextSibling.innerText = fileName;
});
