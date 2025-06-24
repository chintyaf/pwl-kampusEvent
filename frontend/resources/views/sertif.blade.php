<form id="uploadZipForm" enctype="multipart/form-data">
    <input type="file" name="zipFile" id="zipFile" accept=".zip" required>
    <button type="submit">Upload ZIP</button>
</form>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
document.getElementById('uploadZipForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData();
    formData.append('zipFile', document.getElementById('zipFile').files[0]);

    axios.post('http://localhost:3000/upload-zip', formData, {
        headers: { 'Content-Type': 'multipart/form-data' }
    })
    .then(res => alert(res.data.message))
    .catch(err => console.error(err));
});
</script>
